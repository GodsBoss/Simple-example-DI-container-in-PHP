<?php

class SimpleDI_FactoryTest extends PHPUnit_Framework_TestCase{
	public function test_creating_service_definition(){
		$factory = new SimpleDI_ServiceDefinitionFactoryImpl();
		$this->assertTrue($factory->createDefinition('foobar') instanceof SimpleDI_ServiceDefinition);}

	public function test_creating_service_definition_facade(){
		$factory = new SimpleDI_ServiceDefinitionFactoryImpl();
		$definitionMock = $this->getMock('SimpleDI_ServiceDefinition');
		$this->assertTrue($factory->createFacade($definitionMock) instanceof SimpleDI_ServiceDefinitionFacade);}}
