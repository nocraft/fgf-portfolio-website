<?php 
class SearchsController extends Controller{
	
	function index(){


//				 [queryString] => SELECT * FROM posts  WHERE online = 1 AND type != 'page' AND content LIKE '%mot1%' OR content LIKE '%mot2%' OR content LIKE '%mot3%'
//			     [queryString] => SELECT * FROM posts  WHERE online = 1 AND type != 'page'content LIKE '%bleu%' OR content LIKE '%balaine%' OR content LIKE '%chien%'


 		if(isset($_GET['q'])){
			$this->loadModel('Post');
			$q=$_GET['q'];
			$d['search'] = $q;
			$s=explode(" ", $q);

			$symbole = '=,!='; 
			foreach ($s as $k => $v) {
				$condition2[] = array('content' => '%'.$v.'%');
			}
			$condition = array('online' => 1, 'type' => 'page', 'search' => $condition2);

			$d['posts'] = $this->Post->find(array(
				'symbole'	 => $symbole,
				'conditions' => $condition,
				'fields'     => 'posts.id,posts.type,posts.name,posts.slug,posts.created,posts.content,categories.name as catname,categories.slug as catslug',
				'order'      => 'created DESC',
				'join'       => 'left',
				'jointab'    => 'categories',
				'on'       	 => array('category_id' => 'id'),	
			));
			foreach($d['posts'] as $k => $v) {
				$d['posts'][$k] = $v;
				$d['posts'][$k]->comments = $this->getComments($v->id);
				$d['posts'][$k]->date = $this->transDate($v->created); 
				$d['posts'][$k]->media = $this->getMedia($v->id);
			}

			$d['total'] = $this->Post->findCount($condition,$symbole); 
			
			$Cache = new Cache(WEBROOT.DS.'cache', 0);
			$Cache->clear();	
		}
		//debug($d);
		$this->set($d);
	}

	// Pour l'affichage des commentaires
	function getComments($id) {
    $this->loadModel('Comment');
    $d['comments'] = $this->Comment->find(array(
        'conditions' => array('posts_id' => $id),
        'fields' => 'comments.id,comments.pseudo,comments.mail,comments.content,comments.created',
        'order' => 'created ASC',
		'join'       => 'left',
		'jointab'    => 'posts',
		'on'       	 => array('posts_id'=>'id'),
    ));
    $condition = array('posts_id' => $id); 
    $d['totalcomments'] = $this->Comment->findCount($condition);
	return $d;
	}
	
	/**
	* Permet recupere les media
	**/	
	function getMedia($id){
		$this->loadModel('Media');
		$d = $this->Media->find(array(
			'conditions' => array('post_id' => $id
		)));
		if (!$d == null ){
		$d['first'] = 'img'.DS.$d[0]->file;
		};
		
		foreach($d as $k => $v) {
				if (is_int($k)) {
					$v->file = 'img'.DS.$v->file;
				};
		};
		
		
		//debug($d);		
		return $d;
	}
	// Pour transformer la date au format mois ANNEE ( mars 2013 )
	private function transDate($madate) {
		$dateTab = explode('-', $madate );
			
		if (strlen($dateTab[0])==4){$ln='en';}
		if (strlen($dateTab[2])==4){$ln='fr';}
		$m =  $ln=='fr' ? (int)$dateTab[1] : (int)$dateTab[1];
		$Y =  $ln=='fr' ? (int)$dateTab[2] : (int)$dateTab[0];
		$d=   $ln=='fr' ? (int)$dateTab[0] : (int)$dateTab[2];
			 
		$mktime  =  mktime(0, 0, 0, $m , $d,  $Y) ;
			
		setlocale (LC_TIME, 'fr_FR.utf8','fra');
		$date = (string) utf8_encode(strftime('%A', $mktime).' '.strftime('%#d', $mktime).' '.strftime('%B', $mktime).' '.strftime('%Y', $mktime));
		return $date;
	}
}