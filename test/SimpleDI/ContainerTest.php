<?php

class SimpleDI_ContainerTest extends PHPUnit_Framework_TestCase{
	private $factory;
	private $di;
	private $service;

	public function setUp(){
		$this->factory = $this->getMock('SimpleDI_ServiceDefinitionFactory');
		$this->di = new SimpleDI_Container($this->factory);
		$this->service = new StdClass();}

	public function test_parameter(){
		$this->di->setParameter('foo', 'bar');
		$this->assertEquals('bar', $this->di->get('foo'));}

	public function test_returning_container_after_setting_parameter(){
		$this->assertTrue($this->di === $this->di->setParameter('foo', 'bar'));}

	public function test_out_of_bounds_exception_for_invalid_parameters(){
		$this->setExpectedException('OutOfBoundsException');
		$this->di->get('foo');}

	public function serviceDefinitionCreate($di){
		$this->assertEquals($this->di, $di);
		return $this->service;}

	public function prepareFactoryCreateDefinition($class, $definition){
		$this->factory->
			expects($this->once())->
			method('createDefinition')->
			with($class)->
			will($this->returnValue($definition));}

	public function test_service_creation(){
		$name = 'service_name';
		$class = 'ServiceClass';
		$definition = $this->getMock('SimpleDI_ServiceDefinition');
		$definition->
			expects($this->once())->
			method('create')->
			will($this->returnCallback(array($this, 'serviceDefinitionCreate')));
		$facade = $this->getMock('SimpleDI_ServiceDefinitionFacade');
		$this->prepareFactoryCreateDefinition($class, $definition);
		$this->factory->
			expects($this->once())->
			method('createFacade')->
			with($definition)->
			will($this->returnValue($facade));
		$this->assertTrue($facade === $this->di->setService($name, $class));
		$service = $this->di->get($name);
		$this->assertTrue($this->service === $service);
		$this->assertTrue($service === $this->di->get($name));}

	public function test_lazy_creation_of_services(){
		$class = 'ServiceClass';
		$definition = $this->getMock('SimpleDI_ServiceDefinition');
		$definition->
			expects($this->never())->
			method('create');
		$this->prepareFactoryCreateDefinition($class, $definition);
		$this->di->setService('simple', $class);}}
