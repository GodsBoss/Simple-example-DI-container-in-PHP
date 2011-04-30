<?php

/**
* Class for autoloading.
*/
class SimpleDI_Autoload{
	private $dir;

	public function __construct(){
		$this->dir = dirname(__FILE__).'/..';}

	public function register(){
		spl_autoload_register(array($this, 'autoload'));}

	private function isSimpleDIClass($class){
		return substr($class, 0, 8) == 'SimpleDI';}

	private function filename($class){
		return $this->dir.'/'.str_replace('_', '/', $class).'.php';}

	public function autoload($class){
		if ($this->isSimpleDIClass($class)){
			require_once($this->filename($class));}}}
