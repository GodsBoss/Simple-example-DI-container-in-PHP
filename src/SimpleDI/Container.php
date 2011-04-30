<?php

/**
* Container for all services and parameters.
*/
class SimpleDI_Container implements SimpleDI_API{
	private $serviceFactory;
	private $params = array();
	private $services = array();
	private $serviceObjects = array();

	public function __construct(SimpleDI_ServiceDefinitionFactory $factory){
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
