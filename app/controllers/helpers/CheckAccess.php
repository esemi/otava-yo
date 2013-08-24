<?php

class Action_Helper_CheckAccess extends Zend_Controller_Action_Helper_Abstract
{
	public function moderAccess()
	{
		return Zend_Auth::getInstance()->hasIdentity();
	}

	public function direct()
	{
		return $this->moderAccess();
	}

}
