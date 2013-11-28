<?php
class Router{
	

	static $routes = array(); 
	static $prefixes = array(); 

	/**
	* Ajoute un prefix au Routing
	**/
	static function prefix($url,$prefix){
		self::$prefixes[$url] = $prefix; 
	}


	/**
	* Permet de parser une url
	* @param $url Url à parser
	* @return tableau contenant les paramètres
	**/
	static function parse($url,$request){
		$url = trim($url,'/'); 
		if(empty($url)){
			$url = Router::$routes[0]['url']; 
		}else{
			$match = false; 
			foreach(Router::$routes as $v){
				if(!$match && preg_match($v['redirreg'],$url,$match)){
					$url = $v['origin'];
					foreach($match as $k=>$v){
						$url = str_replace(':'.$k.':',$v,$url); 
					} 
					$match = true; 
				}
			}
		}
		
		$params = explode('/',$url);
		if(in_array($params[0],array_keys(self::$prefixes))){
			$request->prefix = self::$prefixes[$params[0]];
			array_shift($params); 
		}
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : 'index';
		foreach(self::$prefixes as $k=>$v){
			if(strpos($request->action,$v.'_') === 0){
				$request->prefix = $v;
				$request->action = str_replace($v.'_','',$request->action);  
			}
		}
		$request->params = array_slice($params,2);
		return true; 
	}


	/**
	* Permet de connecter une url à une action particulière
	**/
	static function connect($redir,$url){
		$r = array();
		$r['params'] = array();
		$r['url'] = $url; // $url (2eme arg) de la fonction

		$r['originreg'] = preg_replace('/([a-z0-9]+):([^\/]+)/','${1}:(?P<${1}>${2})',$url); //analyse $url pour retrouver expression reguliere(1er arg) et la remplacer (par 2eme arg)
		$r['originreg'] = str_replace('/*','(?P<args>/?.*)',$r['originreg']); // remplace l'expression reguliere(arg1) par (arg2) du tableau $r['originreg']
		$r['originreg'] = '/^'.str_replace('/','\/',$r['originreg']).'$/'; // remplace les slash par des antislash
		// MODIF
		$r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/',':${1}:',$url); // remplace expression reg au drapeau '${1}:(?P<${1}>${2})'      (${1})
		$r['origin'] = str_replace('/*',':args:',$r['origin']); // remplace expression reg  au drapeau '(?P<args>/?.*)'  (args

		$params = explode('/',$url); // separe les element par le slash
		foreach($params as $k=>$v){
			if(strpos($v,':')){ // cherche la position de :
				$p = explode(':',$v); // separe a partir du :
				$r['params'][$p[0]] = $p[1];  // renvoye les element en parametre 1 et 2
			}
		} 

		$r['redirreg'] = $redir; // $redir (1er arg) de la fonction
		$r['redirreg'] = str_replace('/*','(?P<args>/?.*)',$r['redirreg']); // remplace l expression reg ...
		foreach($r['params'] as $k=>$v){
			$r['redirreg'] = str_replace(":$k","(?P<$k>$v)",$r['redirreg']); // on remplace par chaque params
		}
		$r['redirreg'] = '/^'.str_replace('/','\/',$r['redirreg']).'$/'; // repasse les antislash en slash

		$r['redir'] = preg_replace('/:([a-z0-9]+)/',':${1}:',$redir); // remplace l'expression reg par le premier drapeau      (${1})
		$r['redir'] = str_replace('/*',':args:',$r['redir']); // dememe pour les args

		self::$routes[] = $r; // returne au route
	}

	/**
	* Permet de générer une url à partir d'une url originale
	* controller/action(/:param/:param/:param...)
	**/
	static function url($url = ''){
		trim($url,'/'); 
		foreach(self::$routes as $v){
			if(preg_match($v['originreg'],$url,$match)){
				$url = $v['redir']; 
				foreach($match as $k=>$w){
					$url = str_replace(":$k:",$w,$url); 
				}
			}
		}
		foreach(self::$prefixes as $k=>$v){
			if(strpos($url,$v) === 0){
				$url = str_replace($v,$k,$url); 
			}
		}
		return BASE_URL.'/'.$url; 
	}

	static function webroot($url){
		trim($url,'/');
		return BASE_URL.'/'.$url; 
	}

}