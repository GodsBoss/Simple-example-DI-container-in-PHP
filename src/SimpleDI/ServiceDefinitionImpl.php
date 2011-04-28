<?php

/**
* A service definition.
*/
class SimpleDI_ServiceDefinitionImpl implements SimpleDI_ServiceDefinition{
	private $className;
	private $arguments = array();

	public function __construct($class){
		$this->className = $class;}

	public function create(SimpleDI_API $di){
		// Big thanks to:
		// http://blog.ebene7.com/2011/03/21/array-als-parameterliste-an-den-konstruktor-uebergeben/
		$args = array();
		foreach($this->arguments as $name){
			$args[] = $di->get($name);}
		$class = new ReflectionClass($this->className);
		return $class->newInstanceArgs($args);}

	public function addArgument($name){
		$this->arguments[] = $name;
		return $this;}}
