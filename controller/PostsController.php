<?php 
class PostsController extends Controller{



	/**
	* Blog, liste les articles
	**/
	function index() {
		$perPage = 3; 
 
		$this->loadModel('Post');
		$symbole = '=,!='; 
		$condition = array('online' => 1, 'type' => 'page'); 
		$d['posts'] = $this->Post->find(array(
			'symbole'	 => $symbole,
			'conditions' => $condition,
			'fields'     => 'posts.id,posts.type,posts.name,posts.slug,posts.created,posts.content,categories.name as catname,categories.slug as catslug',
			'order'      => 'id DESC',
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
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
		$d['page'] = ceil($d['total'] / $perPage);
		//debug($d['total']);
		//debug($d);
		$this->set($d);
	}

	/**
	* Permet d'afficher les posts d'une catégorie
	**/
	function category($slug){
		$this->loadModel('Category'); 
		$category = $this->Category->findFirst(array(
			'conditions' => array('slug' => $slug),
			'fields'     => 'id,name'
		));
		if(empty($category)){
			$this->e404('Category introuvable');
		}
		$perPage = 10; 
		$this->loadModel('Post');
		$symbole = '=,!=,='; 
		$condition = array('online' => 1, 'type' => 'page' ,'category_id' => $category->id); 
		$d['posts'] = $this->Post->find(array(
			'symbole'	 => $symbole,
			'conditions' => $condition,
			'fields'     => 'posts.id,posts.type,posts.name,posts.slug,posts.created,categories.name as catname,posts.content,categories.slug as catslug',
			'order'      => 'created DESC',
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
			'join'       => 'left',
			'jointab'    => 'categories',
			'on'       	 => array('category_id' => 'id'),	
		));
		$d['total'] = $this->Post->findCount($condition,$symbole); 
		foreach($d['posts'] as $k => $v) {
			$d['posts'][$k] = $v;
			$d['posts'][$k]->comments = $this->getComments($v->id);
			$d['posts'][$k]->date = $this->transDate($v->created); 
			$d['posts'][$k]->media = $this->getMedia($v->id);
		}
		
		$d['page'] = ceil($d['total'] / $perPage);
		$d['title'] = 'Tous les articles "'.$category->name.'"'; 
				
		$this->set($d);
		
		//var_dump($this);
		// Le système est le même que la page index alors on rend la vue Index
		$this->render('index');
	}
	
	/**
	* Permet d'afficher les posts par date archive
	**/
	function archive($created = null) {
		$perPage = 10; 
		$this->loadModel('Post');
		$symbole = '=,!=,like'; 
		$condition = array('online' => 1, 'type' => 'page', 'created' => $created.'%'); 
		$d['posts'] = $this->Post->find(array(
			'symbole'	 => $symbole,
			'conditions' => $condition,
			'fields'     => 'posts.id,posts.type,posts.name,posts.slug,posts.created,categories.name as catname,posts.content,categories.slug as catslug',
			'order'      => 'created DESC',
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
			'join'       => 'left',
			'jointab'    => 'categories',
			'on'       	 => array('category_id' => 'id'),	
		));
		$d['total'] = $this->Post->findCount($condition,$symbole); 
		foreach($d['posts'] as $k => $v) {
			$d['posts'][$k] = $v;
			$d['posts'][$k]->comments = $this->getComments($v->id);
			$d['posts'][$k]->date = $this->transDate($v->created); 
			$d['posts'][$k]->media = $this->getMedia($v->id);
		}
		
		$d['page'] = ceil($d['total'] / $perPage);
		$d['title'] = 'Archive du "'.$created.'"'; 
		//debug($d);		
		//debug($created);		
		//debug($condition);		
		$this->set($d);
		
		//var_dump($this);
		// Le système est le même que la page index alors on rend la vue Index
		$this->render('index');
	}

	/**
	* Affiche un article en particulier
	**/
	function view($id, $slug) {
		// Pour l'affichage du post voulu
		$this->loadModel('Post');
		$d['post']  = $this->Post->findFirst(array(
			'symbole'	 => '=,=,!=',
			'conditions' => array('posts.online' => 1, 'posts.id' => $id, 'posts.type' => 'page'),
			'fields'	 => 'posts.id,posts.content,posts.name,posts.slug,posts.created,categories.name as catname,categories.slug as catslug',
			'join'       => 'left',
			'jointab'    => 'categories',
			'on'       	 => array('category_id' => 'id'),
		));
		if(empty($d['post'])){
			$this->e404('Page introuvable'); 
		}
		if($slug != $d['post']->slug){
			$this->redirect("posts/view/id:$id/slug:".$d['post']->slug,301);
		}
		$d['post']->comments = $this->getComments($id);
		$d['post']->date = $this->transDate($d['post']->created); 
		
		if ($this->request->data) {
			if ($this->Comment->validates($this->request->data)) {
				$namecache = ($this->request->controller.'_'.$this->request->action.'_'.$this->request->page.str_replace('/', '_', $this->request->url));
				$Cache = new Cache(WEBROOT.DS.'cache',null);
			    //$Cache->delete($namecache);	
			    $Cache->clear();	
				
                $this->request->data->posts_id = $id;
                $this->request->data->created = date('Y-m-d H:i:s');
				$this->Comment->save($this->request->data);      
				$this->Session->setFlash('Le commentaire a bien été créé');
				$this->redirect("posts/view/id:$id/slug:".$slug); 
			}else{
                $this->Session->setFlash("<strong>Erreur !</strong> Certains champs n'ont pas été rempli correctement, merci de corriger vos erreurs", 'notification error full');
			}
		}
		
		//debug($d);
		$this->set($d);
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
		}
		//debug($d);		
		return $d;
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
	
	function getBreadcrumb() {
		if(isset($_SERVER['PATH_INFO'])) {
			$url = trim($_SERVER['PATH_INFO'], '/');
		} else {
			$url = '';
		}
		$breadcrumb = explode('/', $url);
		return $breadcrumb;
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
	
	/**
	* ADMIN  ACTIONS
	**/
	/**
	* Liste les différents articles
	**/
	function admin_index(){
		$perPage = 10; 
		$this->loadModel('Post');
		$condition = array('type' => 'post'); 
		$d['posts'] = $this->Post->find(array(
			'conditions' => $condition,
			'fields'     => 'Posts.id,Posts.created,Posts.name,Posts.online,categories.name as catname,categories.slug as catslug',
			'order' 	 => 'id DESC',
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
			'join'       => 'left',
			'jointab'    => 'categories',
			'on'       	 => array('category_id' => 'id'),
		));
		$d['total'] = $this->Post->findCount($condition); 
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	/**
	* Permet d'éditer un article
	**/
	function admin_edit($id = null){
		$this->loadModel('Post'); 
		if($id === null){
			$post = $this->Post->findFirst(array(
				'conditions' => array('online' => -1),
			));
			if(!empty($post)){
				$id = $post->id;
			}else{
				$this->Post->save(array(
					'online' => -1,
					'created' 	 => date('Y-m-d'),
				));
				$id = $this->Post->id;
			} 
		}
		$d['id'] = $id; 
		if($this->request->data){
			if($this->Post->validates($this->request->data)){
				$Cache = new Cache(WEBROOT.DS.'cache',null);
			    $Cache-> clear(); 
				
				$this->request->data->type = 'post';
				$this->Post->save($this->request->data);
				$this->Session->setFlash('Le contenu a bien été modifié'); 
				$this->redirect('admin/posts/index'); 
			}else{
				$this->Session->setFlash('Merci de corriger vos informations','error'); 
			}
			
		}else{
			$this->request->data = $this->Post->findFirst(array(
				'conditions' => array('id'=>$id)
			));
		}
		// On veut un sélecteur de catégorie donc on récup la liste des catégories , et condition article/project
		$this->loadModel('Category');
		//$condition = array('typecat' => 'post');
		//$d['categories'] = $this->Category->findList($condition); 
		$d['categories'] = $this->Category->findList(); 
		//debug($this->DataForm->input['category_id']['typecat']);
		//debug($this->request);
		//debug($this->Category);
		$this->set($d);
	}

	/**
	* Permet de supprimer un article
	**/
	function admin_delete($id) {
		$Cache = new Cache(WEBROOT.DS.'cache',null);
		$Cache-> clear(); 
			
		$this->loadModel('Post');
		$this->Post->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé'); 
		$this->redirect('admin/posts/index'); 
	}

	/**
	* Permet de lister les contenus
	**/
	function admin_tinymce(){
		$this->loadModel('Post');
		$this->layout = 'modal'; 
		$d['posts'] = $this->Post->find();
		$this->set($d);
	}


}