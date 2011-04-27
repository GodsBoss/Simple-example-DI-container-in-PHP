<?php

require_once('SimpleDI.php');

class SimpleDITest extends PHPUnit_Framework_TestCase{
	public function test_construction(){
		$di = new SimpleDI();}

	public function test_parameter(){
		$di = new SimpleDI();
		$di->setParameter('foo', 'bar');
		$this->assertEquals('bar', $di->get('foo'));}}
