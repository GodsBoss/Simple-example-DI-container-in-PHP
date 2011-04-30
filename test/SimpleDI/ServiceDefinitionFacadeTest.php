<?php

class SimpleDI_ServiceDefinitionFacadeTest extends PHPUnit_Framework_TestCase{
	public function test_adding_argument(){
		$definition = $this->getMock('SimpleDI_ServiceDefinition');
		$name = 'foo';
		$definition->
			expects($this->once())->
			method('addArgument')->
			with($name)->
			will($this->returnValue($definition));
		$facade = new SimpleDI_ServiceDefinitionFacadeImpl($definition);
		$result = $facade->addArgument($name);
		$this->assertTrue($result === $facade);}}
