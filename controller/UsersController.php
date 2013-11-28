<?php 
class UsersController extends Controller{
	
	/**
	* Login
	**/
	function login(){
		if($this->request->data){
			$data = $this->request->data;
			$data->password = sha1(PREFIX_SALT.$data->password.SUFFIX_SALT); 
			$this->loadModel('User'); 
			$user = $this->User->findFirst(array(
				'conditions' => array('login' => $data->login,'password' => $data->password
			)));
			if(!empty($user)){
				$this->Session->write('User',$user); 
			}
			$this->request->data->password = ''; 
		}
		if($this->Session->isLogged()){
			if($this->Session->user('role') == 'admin'){
				$this->redirect('cockpit');
			}else{
				$this->redirect('');
			}
		}
	}

	/**
	* Logout
	**/
	function logout(){
		unset($_SESSION['User']);
		$this->Session->setFlash('Vous ête mainenant déconnecté'); 
		$this->redirect('/'); 
	}

}