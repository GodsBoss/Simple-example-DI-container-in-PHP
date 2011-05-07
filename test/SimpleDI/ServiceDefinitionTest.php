<?php

class ServiceWithoutDependenciesMock{}

class ServiceWithDependenciesMock{
	private $deps;

	public function __construct($dep1, $dep2){
		$this->deps = array($dep1, $dep2);}

	public function getDependency($index){
		return $this->deps[$index];}}

class ServiceWithMethodsMock{
	private $one, $two, $three;

	public function one($one){
		$this->one = $one;}

	public function twoAndThree($two, $three){
		$this->two   = $two;
		$this->three = $three;}

	public function getOne(){
		return $this->one;}

	public function getTwo(){
		return $this->two;}

	public function getThree(){
		return $this->three;}}

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
		$this->assertEquals($this->deps['bar'], $service->getDependency(1));}

	public function getMethodArgument($name){
		switch($name){
			case 'arg_one'  : return 1;
			case 'arg_two'  : return 2;
			case 'arg_three': return 3;}}

	public function test_adding_method_calls_to_service(){
		$definition = new SimpleDI_ServiceDefinitionImpl('ServiceWithMethodsMock');
		$definition->
			addCall('one', array('arg_one'))->
			addCall('twoAndThree', array('arg_two', 'arg_three'));
		$container = $this->getMock('SimpleDI_API');
		$container->
			expects($this->exactly(3))->
			method('get')->
			will($this->returnCallback(array($this, 'getMethodArgument')));
		$service = $definition->create($container);
		$this->assertEquals($this->getMethodArgument('arg_one'), $service->getOne());
		$this->assertEquals($this->getMethodArgument('arg_two'), $service->getTwo());
		$this->assertEquals($this->getMethodArgument('arg_three'), $service->getThree());}}
