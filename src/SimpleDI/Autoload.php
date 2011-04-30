<?php

/**
* Autoloader.
*/
class SimpleDI_Autoload{
	/**
	* Base directory for class files.
	*/
	private $dir;

	public function __construct(){
		$this->dir = dirname(__FILE__).'/..';}

	/**
	* Registers this autoloader via spl_autoload_register().
	*/
	public function register(){
		spl_autoload_register(array($this, 'autoload'));}

	/**
	* Checks if the class name corresponds to a SimpleDI class.
	*
	* @param $class
	*   Class name.
	*
	* @return
	*   TRUE, if it does, else FALSE.
	*/
	private function isSimpleDIClass($class){
		return substr($class, 0, 8) == 'SimpleDI';}

	/**
	* Returns the filename corresponding to the class name.
	*
	* @param $class
	*   Class name.
	*
	* @return
	*   The filename.
	*/
	private function filename($class){
		return $this->dir.'/'.str_replace('_', '/', $class).'.php';}

	/**
	* Loads the file corresponding to the class if it is a SimpleDI class.
	*
	* @param $class
	*   Name of the class to be loaded.
	*/
	public function autoload($class){
		if ($this->isSimpleDIClass($class)){
			require_once($this->filename($class));}}}
