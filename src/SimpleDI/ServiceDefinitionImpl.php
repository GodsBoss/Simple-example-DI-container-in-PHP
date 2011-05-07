<?php

/**
* Standard implementation of a service definition.
*/
class SimpleDI_ServiceDefinitionImpl implements SimpleDI_ServiceDefinition{
	/**
	* The service's class name.
	*/
	private $className;

	/**
	* Argument names used for getting the arguments which will be passed to the
	* service's constructor.
	*/
	private $arguments = array();

	/**
	* Method calls.
	*/
	private $calls = array();

	/**
	* Constructor.
	*
	* @param $class
	*   The service's class name.
	*/
	public function __construct($class){
		$this->className = $class;}

	/**
	* Create instance of a service.
	*
	* @param $di
	*   DI container for getting constructor arguments.
	*
	* @return
	*   The service to be created.
	*/
	private function createInstance(SimpleDI_API $di){
		// Big thanks to:
		// http://blog.ebene7.com/2011/03/21/array-als-parameterliste-an-den-konstruktor-uebergeben/
		$args = array();
		foreach($this->arguments as $name){
			$args[] = $di->get($name);}
		$class = new ReflectionClass($this->className);
		return $class->newInstanceArgs($args);}

	/**
	* Calls methods on the service.
	*
	* @param $di
	*   DI container for getting method arguments.
	*
	* @return
	*   The service.
	*/
	private function callMethods($service, SimpleDI_API $di){
		foreach($this->calls as $call){
			$args = call_user_func_array(array($service, $call['name']), array_map(array($di, 'get'), $call['argument_names']));}
		return $service;}

	public function create(SimpleDI_API $di){
		return $this->callMethods($this->createInstance($di), $di);}

	public function addArgument($name){
		$this->arguments[] = $name;
		return $this;}

	public function addCall($name, $argNames = array()){
		$this->calls[] = array('name' => $name, 'argument_names' => $argNames);
		return $this;}}
