<?php

class SimpleDI{
	private $params = array();

	public function setParameter($name, $value){
		$this->params[$name] = $value;
		return $this;}

	public function get($name){
		if (array_key_exists($name, $this->params)){
			return $this->params[$name];}
		else{
			throw new OutOfBoundsException();}}}
