<?php

class Kernel {

	/**
    * Includes an object file for use in an application.
	*
	* @param string $namespace library name
    */
    function includeObject($namespace) {
		require_once dirname(__FILE__).'/'.$namespace.'.php';
		//return call_user_func(array($namespace, '_autoInclude'));
    }

	/**
    * Takes 2 arguments, on the file name, the
    * other is the variable that will
    * contain the object. PassedByRef.
	*
	* @param string $namespace library name
	* @param reference &$object reference to the object
    */
    function includeObjectInto($namespace, &$object) {
		require_once dirname(__FILE__).'/'.$namespace.'.php';
 		//return call_user_func(array($namespace, '_autoIncludeInto'), $object);
	}
}
?>