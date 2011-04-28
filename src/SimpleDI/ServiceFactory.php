<?php

/**
* Creates service definition and service definition facades.
*/
class SimpleDI_ServiceFactory{
	public function createDefinition($class){
		return new SimpleDI_ServiceDefinition($class);}

	public function createFacade(SimpleDI_ServiceDefinition $definition){
		return new SimpleDI_ServiceDefinitionFacade($definition);}}
