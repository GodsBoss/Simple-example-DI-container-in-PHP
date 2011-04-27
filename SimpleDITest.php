<?php

require_once('SimpleDI.php');

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

class SimpleDITest extends PHPUnit_Framework_TestCase{
	public function test_construction(){
		$di = new SimpleDI();}

	public function test_parameter(){
		$di = new SimpleDI();
		$di->setParameter('foo', 'bar');
		$this->assertEquals('bar', $di->get('foo'));}

	public function test_returning_container_after_setting_parameter(){
		$di = new SimpleDI();
		$this->assertTrue($di === $di->setParameter('foo', 'bar'));}

	public function test_out_of_bounds_exception_for_invalid_parameters(){
		$di = new SimpleDI();
		$this->setExpectedException('OutOfBoundsException');
		$di->get('foo');}

	public function test_simple_service(){
		$di = new SimpleDI();
		$di->setService('simple', 'SimpleServiceMock');
		$simple = $di->get('simple');
		$this->assertEquals('SimpleServiceMock', get_class($simple));}

	public function test_lazy_creation_of_services(){
		SimpleServiceMock::$created = FALSE;
		$di = new SimpleDI();
		$di->setService('simple', 'SimpleServiceMock');
		$this->assertFalse(SimpleServiceMock::$created);}

	public function test_singleton_services(){
		$di = new SimpleDI();
		$di->setService('simple', 'SimpleServiceMock');
		$this->assertTrue($di->get('simple') === $di->get('simple'));}

	public function test_service_with_arguments(){
		$di = new SimpleDI();
		$di->
			setService('complex', 'ServiceWithArgumentsMock')->
			addArgument('name')->
			addArgument('dependency');
		$di->setParameter('name', 'shtring');
		$di->setService('dependency', 'ServiceDependencyMock');
		$complex = $di->get('complex');
		$this->assertEquals('ServiceWithArgumentsMock', get_class($complex));
		$this->assertEquals($complex->getName(), $di->get('name'));
		$this->assertEquals($complex->getDependency(), $di->get('dependency'));}}
