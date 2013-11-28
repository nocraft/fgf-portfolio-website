<?php 
class CategoriesController extends Controller{
	
	/**
	* Permet de récup la liste des catégories et le nombre de post pour le blog
	**/
	function index() {
		$this->loadModel('Category');
		$y['cats'] = $this->Category->find(array(
			'order'      => 'name ASC',
		));
		// recupere le nombres de post par categorie
		$this->loadModel('Post');
		$condition = array('online' => 1,'type'=>'page'); 
		$y['posts'] = $this->Post->find(array(
			'symbole'	 => '=,!=',
			'conditions' => $condition,
			'fields'     => 'posts.category_id,posts.created as date',
			'order'      => 'date DESC',
		));
		
		// posts
		$y['jointTotalCat'] = array();	
		foreach($y['posts'] as $k => $v) {
			$y['posts'][$k]->categories = $this->getCategory($v->category_id);
 			$y['jointTotalCat'][$v->category_id] = new stdClass;
			$y['jointTotalCat'][$v->category_id]->totalcategories = $y['posts'][$k]->categories['totalcategory'];
 		}
		
		// recupere le nombres de post par date
		foreach($y['posts'] as $k => $v) {			
			$y['posts'][$k]->categories = $this->getCategory($v->category_id);
			$date = $this->transDate($v->date); 
			$datebase = explode('-', $v->date, -1);
			$dateid = implode("-", $datebase);

			if( !isset($y['jointDatePostId'][$dateid]) ) {
				$y['jointDatePostId'][$dateid]=array('totalByDate'=>0); 
			}
			$totalAdd = isset($y['posts'][$k]->categories['totalcategory']) ? isset($y['posts'][$k]->categories['totalcategory']) : 0 ;
			$y['jointDatePostId'][$dateid]['date'] = $date;
 			$y['jointDatePostId'][$dateid]['totalByDate'] += $totalAdd;
 		}
		
		krsort($y['jointDatePostId']);
 		return $y ;
	}
	
	// Pour l'affichage le nombres de post par category
	private function getCategory($id) {
		$condition = array('online' => 1,'category_id' => $id); 
		$d['totalcategory'] = $this->Post->findCount($condition);
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
		$date = (string) utf8_encode(strftime('%B', $mktime).' '.strftime('%Y', $mktime));
		return $date;
	}
		
	/**
	* ADMIN  ACTIONS
	**/
	/**
	* Liste les différents articles
	**/
	function admin_index(){
		$this->loadModel('Category');
		$condition = array('type'=>'Category'); 
		$d['categories'] = $this->Category->find(array(
			'fields'     => 'id,name,slug,desccat,typecat',
		));
		$this->set($d);
	}

	/**
	* Permet d'éditer un article
	**/
	function admin_edit($id = null){
		$this->loadModel('Category'); 
		
		if($this->request->data){
			if ($this->Category->validates($this->request->data)) {
				$Cache = new Cache(WEBROOT.DS.'cache',null);
			    $Cache-> clear(); 
				
				$this->Category->save($this->request->data);
				$this->Session->setFlash('La catégorie a bien été modifié'); 
				$this->redirect('admin/categories/index'); 
			}else{
				$this->Session->setFlash('Merci de corriger vos informations','error'); 
			}
			
		}elseif($id){
			$this->request->data = $this->Category->findFirst(array(
				'conditions' => array('id'=>$id)
			));
		}
		$d['id'] = $id; 
		$this->set($d);
	}

	/**
	* Permet de supprimer un article
	**/
	function admin_delete($id) {
		$Cache = new Cache(WEBROOT.DS.'cache',null);
		$Cache-> clear(); 
		$this->loadModel('Category');
		$this->Category->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé'); 
		$this->redirect('admin/categories/index'); 
	}

	/**
	* Permet de lister les contenus
	**/
	function admin_tinymce(){
		$this->loadModel('Category');
		$this->layout = 'modal'; 
		$d['Categorys'] = $this->Category->find();
		$this->set($d);
	}


}