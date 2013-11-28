<?php
class Cache{
	
/*
  $Cache = new Cache($dirname,$duration);			  $Cache = new Cache(WEBROOT.DS.'cache'.DS.'_db',60);    (60 = 1h)
*/
	public $dirname;
	public $duration; //en Minute (60 = 1h)
	public $buffer;

	
	public function __construct($dirname,$duration){
		$this->dirname = $dirname; 
		$this->duration = $duration; 
	}
	
	public function write($filename, $content) {
		return file_put_contents($this->dirname.DS.$filename, $content);
	}
	
	public function read($filename) {
		$file = $this->dirname.DS.$filename;
		if (!file_exists($file)) {
			return false;
		}
		$lifetime = (time() - filemtime($file)) / 60;
		if ($lifetime > $this->duration) {
			return false;
		}
		return file_get_contents($file);
	}
	
	public function delete($filname){
		$file = $this->dirname.DS.$filename;
		debug($filename);
		if (file_exists($file)) {
			unlink($file);
		}
	}
	
	public function clear(){
		$files = glob($this->dirname.'/*');
		foreach( $files as $file ) {
			unlink($file);
		}
	}
	
	public function inc($file, $cachename = null) {
		if (!$cachename) {
			$cachename = basename($file);
		}
		if ($content = $this->read($cachename)) {
			echo $content;
			return true;
		}
		ob_start();
		require $file;
		$content = ob_get_clean();
		$this->write($cachename, $content);
		echo $content;
		return true;
	}
	
	public function start($cachename) {
		if ($content = $this->read($cachename)) {
			echo $content;
			$this->buffer = false;
			return true;
		}
		ob_start();
		$this->buffer = $cachename;
	}
	
	public function end() {
		if (!$this->buffer) {
			return false;
		}
		$content = ob_get_clean();
		$this->write($this->buffer, $content);
		echo $content;
	}
}