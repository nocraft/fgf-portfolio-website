<?php 
class MediasController extends Controller{
	
	function admin_index($id){
		$this->loadModel('Media');
		if($this->request->data && !empty($_FILES['file']['name'])){
			if(strpos($_FILES['file']['type'], 'image') !== false){
				$dir = WEBROOT.DS.'img'.DS.date('Y-m');
				if(!file_exists($dir)) mkdir($dir,0777); 
				move_uploaded_file($_FILES['file']['tmp_name'], $dir.DS.$_FILES['file']['name']);
				resizeImage($dir.DS.$_FILES['file']['name'],205,137);
				resizeImage($dir.DS.$_FILES['file']['name'],330,210);
				resizeImage($dir.DS.$_FILES['file']['name'],615,274);
				resizeImage($dir.DS.$_FILES['file']['name'],1016,500);
				$this->Media->save(array(
					'name' => $this->request->data->name,
					'file' => date('Y-m').'/'.$_FILES['file']['name'],
					'post_id' => $id,
					'type' => 'img'
				));
				$this->Session->setFlash("L'image a bien été uploadé");
				$this->redirect('admin/portfolios/edit/'.$id);
			}else{
				$this->Form->errors['file'] = "Le fichier n'est pas une image";
			}
		}
		//$this->layout = 'modal';
		$d['images'] = $this->Media->find(array(
			'conditions' => array('post_id' => $id
		))); 
		$d['post_id'] = $id;
		$this->set($d); 
	}
		
	function admin_delete($id){
		$this->loadModel('Media');
		$media = $this->Media->findFirst(array(
			'conditions' => array('id'=>$id)
		));
		$images = glob(WEBROOT.DS.'img'.DS.pathinfo($media->file, PATHINFO_DIRNAME).DS.pathinfo($media->file, PATHINFO_FILENAME)."_*x*.*");
		if (is_array($images)) {
			foreach($images as $image) {
				unlink($image);
			}
		}
		
		unlink(WEBROOT.DS.'img'.DS.$media->file);
		$this->Media->delete($id);
		$this->Session->setFlash("Le média a bien été supprimé");
		$this->redirect('admin/portfolios/edit/'.$media->post_id);
	}

}