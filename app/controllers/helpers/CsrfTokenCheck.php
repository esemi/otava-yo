<?php

/*
 * хелпер для проверки токена
 */
class Action_Helper_CsrfTokenCheck extends Zend_Controller_Action_Helper_Abstract
{
	public function direct($token)
	{
		$user = Zend_Auth::getInstance()->getStorage()->read();
		if( is_null($user) || $user->csrf !== $token ){
			throw new Mylib_Exception_CSRF();
		}
	}
}
