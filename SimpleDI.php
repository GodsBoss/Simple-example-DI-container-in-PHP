<?php

/**
* A service definition.
*/
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

/**
* Facade visible to the client. Does not allow instantiation of services.
*/
class SimpleDI_ServiceDefinitionFacade{
	private $definition;

	public function __construct(SimpleDI_ServiceDefinition $definition){
		$this->definition = $definition;}

	public function addArgument($name){
		$this->definition->addArgument($name);
		return $this;}}

class SimpleDI_ServiceFactory{
	public function createDefinition($class){
		return new SimpleDI_ServiceDefinition($class);}

	public function createFacade(SimpleDI_ServiceDefinition $definition){
		return new SimpleDI_ServiceDefinitionFacade($definition);}}

/**
* Container for all services and parameters.
*/
class SimpleDI{
	private $serviceFactory;
	private $params = array();
	private $services = array();
	private $serviceObjects = array();

	public function __construct(SimpleDI_ServiceFactory $factory){
		$this->serviceFactory = $factory;}

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
		$this->services[$name] = $this->serviceFactory->createDefinition($class);
		return $this->serviceFactory->createFacade($this->services[$name]);}}
