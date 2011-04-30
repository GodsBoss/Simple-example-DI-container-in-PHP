<?php

/**
* Wraps a service definition and only exposes methods to configure it, but none
* to create it.
*/
class SimpleDI_ServiceDefinitionFacadeImpl implements SimpleDI_ServiceDefinitionFacade{
	/**
	* Service definition.
	*/
	private $definition;

	/**
	* Constructor.
	*
	* @param $definition
	*   Service definition which can be configured via this facade.
	*/
	public function __construct(SimpleDI_ServiceDefinition $definition){
		$this->definition = $definition;}

	public function addArgument($name){
		$this->definition->addArgument($name);
		return $this;}}
