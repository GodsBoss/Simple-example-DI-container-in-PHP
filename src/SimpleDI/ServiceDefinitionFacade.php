<?php

/**
* Facade visible to the client. Does not allow instantiation of services.
*/
interface SimpleDI_ServiceDefinitionFacade{
	/**
	* Adds an argument which will be used as an argument to the constructor of
	* the service.
	*
	* @param $name
	*   A service or parameter name.
	*
	* @return
	*   The definition facade for further configuration.
	*/
	public function addArgument($name);}
