<?php

class Action_Helper_CheckLocale extends Zend_Controller_Action_Helper_Abstract
{

	public function preDispatch()
	{
		$lang = $this->getRequest()->getParam('lang');
		var_dump($lang);
	}
}