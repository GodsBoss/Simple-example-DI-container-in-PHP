<?php

class SimpleDI{
	private $params = array();
	private $services = array();

	public function setParameter($name, $value){
		$this->params[$name] = $value;
		return $this;}

	public function get($name){
		if (array_key_exists($name, $this->params)){
			return $this->params[$name];}
		else{
			if (array_key_exists($name, $this->services)){
				$class = $this->services[$name];
				return new $class();}
			else{
				throw new OutOfBoundsException();}}}

	public function setService($name, $class){
		$this->services[$name] = $class;}}
