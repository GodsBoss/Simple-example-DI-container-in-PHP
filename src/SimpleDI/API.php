<?php

/**
* Main API.
*
* Beware: Parameters and services share namespaces. It's possible to register a
* service with the same name as a parameter, but the service will be shadowed
* by the parameter, i.e. it is not possible to get the service.
*/
interface SimpleDI_API{
	/**
	* Sets a parameter. Used for non-object things like strings, booleans,
	* integers, etc. Can also be used for objects, but this is not recommended.
	*
	* @param $name
	*   The parameter's name.
	* @param $value
	*   The parameter's value.
	*
	* @return
	*   The API implementor, so several parameters can be set fluently.
	*/
	public function setParameter($name, $value);

	/**
	* Registers a service.
	*
	* @param $name
	*   The service's name.
	* @param $class
	*   The service's class.
	*
	* @return
	*   A service definition facade which allows to configure the service.
	*/
	public function setService($name, $class);

	/**
	* Returns a service or the value of a parameter. Services are created only
	* once, so successive calls to get the same service will return the same
	* object.
	*
	* @param $name
	*   A parameter or service name.
	*
	* @return
	*   Whatever the name corresponds to. If there is a parameter with that
	*   name, return its value. If there is a service with that name, it will
	*   be created if necessary and returned.
	*
	* @throws OutOfBoundsException
	*   If neither a parameter nor a service with the given name exists.
	*/
	public function get($name);}
