<?php

class Action_Helper_ForceAjaxRequest extends Zend_Controller_Action_Helper_Abstract
{
	public function direct()
	{
		$controller = $this->getActionController();
		$controller->getHelper('contextSwitch')->initContext('json');
		$validHost = $controller->getRequest()->getHttpHost();

		if( !$controller->getRequest()->isXmlHttpRequest() )
			throw new Exception('AJAX only');

		if( $validHost !== mb_substr($controller->getRequest()->getServer('HTTP_REFERER', ''), 0, mb_strlen($validHost) ) )
			throw new Exception('AJAX referer');
	}
}