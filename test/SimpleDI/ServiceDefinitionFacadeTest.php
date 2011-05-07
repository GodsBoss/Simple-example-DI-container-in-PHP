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
		$this->assertTrue($result === $facade);}

	public function test_adding_method_call(){
		$definition = $this->getMock('SimpleDI_ServiceDefinition');
		$name = 'foo';
		$args = array(4, 6);
		$definition->
			expects($this->once())->
			method('addCall')->
			with($name, $args)->
			will($this->returnValue($definition));
		$facade = new SimpleDI_ServiceDefinitionFacadeImpl($definition);
		$result = $facade->addCall($name, $args);
		$this->assertTrue($result === $facade);}}
