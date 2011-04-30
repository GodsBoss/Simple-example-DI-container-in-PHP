<?php

interface SimpleDI_ServiceDefinitionFactory{
	public function createDefinition($class);
	public function createFacade(SimpleDI_ServiceDefinition $definition);}
