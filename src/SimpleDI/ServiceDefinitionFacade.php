<?php

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
