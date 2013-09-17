<?php

class Zend_View_Helper_CsrfToken extends Zend_View_Helper_Abstract
{
	public function csrfToken()
	{
		$user = Zend_Auth::getInstance()->getStorage()->read();
		return ( is_null($user) ) ? '' : $user->csrf;
	}
}
