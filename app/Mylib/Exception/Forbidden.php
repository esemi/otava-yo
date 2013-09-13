<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Exception
 *
 * @author esemi
 */
class Mylib_Exception_Forbidden extends Exception
{
	public function __construct($message='Access error', $code=403, $previous=null)
	{
		parent::__construct($message, $code, $previous);
	}
}

?>
