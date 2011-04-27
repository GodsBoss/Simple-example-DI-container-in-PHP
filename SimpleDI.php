<?php

class SimpleDI{
	private $params = array();

	public function setParameter($name, $value){
		$this->params[$name] = $value;
		return $this;}

	public function get($name){
		return $this->params[$name];}}
