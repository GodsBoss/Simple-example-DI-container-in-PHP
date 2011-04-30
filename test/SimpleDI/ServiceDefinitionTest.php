<?php

class ServiceWithoutDependenciesMock{}

class ServiceWithDependenciesMock{
	private $deps;

	public function __construct($dep1, $dep2){
		$this->deps = array($dep1, $dep2);}

	public function getDependency($index){
		return $this->deps[$index];}}

class SimpleDI_ServiceDefinitionTest extends PHPUnit_Framework_TestCase{
	public function test_creation_of_service_without_dependencies(){
		$class = 'ServiceWithoutDependenciesMock';
		$definition = new SimpleDI_ServiceDefinitionImpl($class);
		$container = $this->getMock('SimpleDI_API');
		$service = $definition->create($container);
		$this->assertTrue($service instanceof $class);}

	private $deps = array('foo' => 'F00', 'bar' => 'RaB');

	public function getDependency($name){
		return $this->deps[$name];}

	public function test_adding_dependencies_to_service(){
		$definition = new SimpleDI_ServiceDefinitionImpl('ServiceWithDependenciesMock');
		$definition->
			addArgument('foo')->
			addArgument('bar');
		$container = $this->getMock('SimpleDI_API');
		$container->
			expects($this->exactly(2))->
			method('get')->
			will($this->returnCallback(array($this, 'getDependency')));
		$service = $definition->create($container);
		$this->assertEquals($this->deps['foo'], $service->getDependency(0));
		$this->assertEquals($this->deps['bar'], $service->getDependency(1));}}
