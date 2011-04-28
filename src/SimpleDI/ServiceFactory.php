<?php

interface SimpleDI_ServiceFactory{
	public function createDefinition($class);
	public function createFacade(SimpleDI_ServiceDefinition $definition);}
