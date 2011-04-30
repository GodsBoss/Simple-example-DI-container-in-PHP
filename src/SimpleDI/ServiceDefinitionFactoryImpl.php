<?php

/**
* Creates service definition and service definition facades.
*/
class SimpleDI_ServiceDefinitionFactoryImpl implements SimpleDI_ServiceDefinitionFactory{
	public function createDefinition($class){
		return new SimpleDI_ServiceDefinitionImpl($class);}

	public function createFacade(SimpleDI_ServiceDefinition $definition){
		return new SimpleDI_ServiceDefinitionFacadeImpl($definition);}}
