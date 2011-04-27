<?php

require_once('SimpleDI.php');

class SimpleServiceMock{}

class SimpleDITest extends PHPUnit_Framework_TestCase{
	public function test_construction(){
		$di = new SimpleDI();}

	public function test_parameter(){
		$di = new SimpleDI();
		$di->setParameter('foo', 'bar');
		$this->assertEquals('bar', $di->get('foo'));}

	public function test_out_of_bounds_exception_for_invalid_parameters(){
		$di = new SimpleDI();
		$this->setExpectedException('OutOfBoundsException');
		$di->get('foo');}

	public function test_simple_service(){
		$di = new SimpleDI();
		$di->setService('simple', 'SimpleServiceMock');
		$simple = $di->get('simple');
		$this->assertEquals('SimpleServiceMock', get_class($simple));}}
