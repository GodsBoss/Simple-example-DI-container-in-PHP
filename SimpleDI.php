<?php

class SimpleDI_ServiceDefinition{
	private $className;
	private $arguments = array();

	public function __construct($class){
		$this->className = $class;}

	public function create(SimpleDI $di){
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

class SimpleDI_ServiceDefinitionFacade{
	private $definition;

	public function __construct(SimpleDI_ServiceDefinition $definition){
		$this->definition = $definition;}

	public function addArgument($name){
		$this->definition->addArgument($name);
		return $this;}}

class SimpleDI{
	private $params = array();
	private $services = array();
	private $serviceObjects = array();

	public function setParameter($name, $value){
		$this->params[$name] = $value;
		return $this;}

	private function maybeCreateServiceObject($name){
		if (!array_key_exists($name, $this->serviceObjects)){
			$this->serviceObjects[$name] = $this->services[$name]->create($this);}}

	private function findService($name){
		if (array_key_exists($name, $this->services)){
			$this->maybeCreateServiceObject($name);
			return $this->serviceObjects[$name];}
		else{
			throw new OutOfBoundsException();}}

	public function get($name){
		if (array_key_exists($name, $this->params)){
			return $this->params[$name];}
		else{
			return $this->findService($name);}}

	public function setService($name, $class){
		$this->services[$name] = new SimpleDI_ServiceDefinition($class);
		return new SimpleDI_ServiceDefinitionFacade($this->services[$name]);}}
