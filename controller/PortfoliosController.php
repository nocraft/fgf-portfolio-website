<?php 
class PortfoliosController extends Controller{
	
	/**
	* Portfolio, liste les different projects
	**/
	function index() {
		$perPage = 30; 
 
		$this->loadModel('Post');
		$condition = array('online' => 1, 'type' => 'project'); 
		$d['posts'] = $this->Post->find(array(
			'conditions' => $condition,
			'fields'     => 'posts.id,posts.name,posts.slug,posts.created,posts.type,posts.content,categories.name as catname,categories.slug as catslug,categories.desccat as catdesc',
			'order'      => 'created DESC',
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
		
		$d['total'] = $this->Post->findCount($condition); 
		$d['page'] = ceil($d['total'] / $perPage);
		
	//	debug($d);
		$this->set($d);
		
	}	
	/**
	* Affiche un project en particulier
	**/
	function view($id, $slug) {
		// Pour l'affichage du post voulu
		$this->loadModel('Post');
		$d['post']  = $this->Post->findFirst(array(
			'conditions' => array('posts.online' => 1, 'posts.id' => $id, 'posts.type' => 'project'),
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
		$d['post']->media = $this->getMedia($id);
				$namecache = ($this->request->controller.'_'.$this->request->action.'_'.$this->request->page.str_replace('/', '_', $this->request->url));
//debug($namecache);
		if ($this->request->data) {
			if ($this->Comment->validates($this->request->data)) {
				$Cache = new Cache(WEBROOT.DS.'cache',null);
			    //$Cache->delete($namecache);			
				$Cache->clear();
				
                $this->request->data->posts_id = $id;
                $this->request->data->created = date('Y-m-d H:i:s');
				$this->Comment->save($this->request->data);      
				$this->Session->setFlash('Le commentaire a bien été créé');
				$this->redirect("portfolios/view/id:$id/slug:".$slug); 
			}else{
                $this->Session->setFlash("<strong>Erreur !</strong> Certains champs n'ont pas été rempli correctement, merci de corriger vos erreurs", 'notification error full');
			}
		}
		
		//debug($this);
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
	
	/**
	* Liste les différents articles
	**/
	function admin_index(){
		$perPage = 10; 
		$this->loadModel('Post');
		$condition = array('type' => 'project'); 
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
		foreach($d['posts'] as $k => $v) {
			$d['posts'][$k] = $v;
			$d['posts'][$k]->media = $this->getMedia($v->id);
		}
		//debug($d);
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
				
				$this->request->data->type = 'project';
				$this->Post->save($this->request->data);
				$this->Session->setFlash('Le contenu a bien été modifié'); 
				$this->redirect('admin/portfolios/index'); 
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
		$d['media'] = $this->getMedia($id);
		//debug($d);
		$this->set($d);
	}

	/**
	* Permet de supprimer un article
	**/
	function admin_delete($id) {
		$Cache = new Cache(WEBROOT.DS.'cache',null);
		$Cache-> clear(); 
			
		$this->loadModel('Post');

		$media = $this->getMedia($id);
		foreach ($media as $k => $v) {
			if (is_int($k)) {
				$images = glob(WEBROOT.DS.pathinfo($v->file, PATHINFO_DIRNAME).DS.pathinfo($v->file, PATHINFO_FILENAME)."_*x*.*");	
				if (is_array($images)) {
					foreach($images as $image) {
						unlink($image);
					}
					unlink($v->file);

				}
			$this->Media->delete($v->id);
			}		
		}		
		$this->Post->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé'); 
		$this->redirect('admin/portfolios/index'); 
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