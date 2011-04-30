<?php

/**
* Container for all services and parameters, implements the main API.
*/
class SimpleDI_Container implements SimpleDI_API{
	/**
	* Factory to create service definitions and service definition facades.
	*/
	private $serviceFactory;

	/**
	* Stores parameters.
	*/
	private $params = array();

	/**
	* Stores service definitions.
	*/
	private $services = array();

	/**
	* Stores services.
	*/
	private $serviceObjects = array();

	public function __construct(SimpleDI_ServiceDefinitionFactory $factory){
		$this->serviceFactory = $factory;}

	public function setParameter($name, $value){
		$this->params[$name] = $value;
		return $this;}

	/**
	* Creates a service if that service does not exist yet.
	*
	* @param $name
	*   The service's name.
	*
	* @see findService()
	*/
	private function maybeCreateServiceObject($name){
		if (!array_key_exists($name, $this->serviceObjects)){
			$this->serviceObjects[$name] = $this->services[$name]->create($this);}}

	/**
	* Tries to find a service with the given name.
	*
	* @param $name
	*   The service's name.
	*
	* @return
	*   The service.
	*
	* @throws OutOfBoundsException
	*   If no service with that name exists.
	*/
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
