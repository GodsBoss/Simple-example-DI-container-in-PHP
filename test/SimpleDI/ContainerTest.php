<?php

class SimpleServiceMock{
	public static $created = FALSE;

	public function __construct(){
		self::$created = TRUE;}}

class ServiceDependencyMock{}

class ServiceWithArgumentsMock{
	private $name;
	private $dependency;

	public function __construct($name, $dependency){
		$this->name       = $name;
		$this->dependency = $dependency;}

	public function getName(){
		return $this->name;}

	public function getDependency(){
		return $this->dependency;}}

class SimpleDI_ContainerTest extends PHPUnit_Framework_TestCase{
	private $di;

	public function setUp(){
		$this->di = new SimpleDI_Container(new SimpleDI_ServiceDefinitionFactoryImpl());}

	public function test_parameter(){
		$this->di->setParameter('foo', 'bar');
		$this->assertEquals('bar', $this->di->get('foo'));}

	public function test_returning_container_after_setting_parameter(){
		$this->assertTrue($this->di === $this->di->setParameter('foo', 'bar'));}

	public function test_out_of_bounds_exception_for_invalid_parameters(){
		$this->setExpectedException('OutOfBoundsException');
		$this->di->get('foo');}

	public function test_simple_service(){
		$this->di->setService('simple', 'SimpleServiceMock');
		$simple = $this->di->get('simple');
		$this->assertEquals('SimpleServiceMock', get_class($simple));}

	public function test_lazy_creation_of_services(){
		SimpleServiceMock::$created = FALSE;
		$this->di->setService('simple', 'SimpleServiceMock');
		$this->assertFalse(SimpleServiceMock::$created);}

	public function test_singleton_services(){
		$this->di->setService('simple', 'SimpleServiceMock');
		$this->assertTrue($this->di->get('simple') === $this->di->get('simple'));}

	public function test_service_with_arguments(){
		$this->di->
			setService('complex', 'ServiceWithArgumentsMock')->
			addArgument('name')->
			addArgument('dependency');
		$this->di->setParameter('name', 'shtring');
		$this->di->setService('dependency', 'ServiceDependencyMock');
		$complex = $this->di->get('complex');
		$this->assertEquals('ServiceWithArgumentsMock', get_class($complex));
		$this->assertEquals($complex->getName(), $this->di->get('name'));
		$this->assertEquals($complex->getDependency(), $this->di->get('dependency'));}}
