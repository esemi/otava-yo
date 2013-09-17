<?php

/**
 * Description of Exception
 *
 * @author esemi
 */
class Mylib_Exception_CSRF extends Exception
{
	public function __construct($message='CSRF token invalid', $code=500, $previous=null){
		parent::__construct($message, $code, $previous);
	}
}

?>
