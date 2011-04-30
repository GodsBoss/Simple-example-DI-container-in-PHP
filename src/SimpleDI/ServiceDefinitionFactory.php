<?php

/**
* Creates service definitions and service definition facades.
*/
interface SimpleDI_ServiceDefinitionFactory{
	/**
	* Creates a service definition for the given class.
	*
	* @param $class
	*   The name of the class to be defined as a service.
	*
	* @return
	*   A service definition.
	*/
	public function createDefinition($class);

	/**
	* Creates a facade for the given service definition.
	*
	* @param $definition
	*   The service definition.
	*
	* @return
	*   A facade which allows only to add methods, but not to create the
	*   service defined by the definition.
	*/
	public function createFacade(SimpleDI_ServiceDefinition $definition);}
