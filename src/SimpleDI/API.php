<?php

interface SimpleDI_API{
	public function setParameter($name, $value);
	public function setService($name, $class);
	public function get($name);}
