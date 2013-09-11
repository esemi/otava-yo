<?php

class Action_Helper_ForceAjaxRequest extends Zend_Controller_Action_Helper_Abstract
{
	//@todo logging
	//@todo disable layout and view
	public function direct()
	{
		$controller = $this->getActionController();
		$controller->getHelper('AjaxContext')
							->addActionContext($this->getRequest()->getActionName(), 'json')
							->initContext('json');

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$validHost = $viewRenderer->view->serverUrl();

		if( !$controller->getRequest()->isXmlHttpRequest() ){
			throw new Exception('AJAX only');
		}

		if( $validHost !== mb_substr($controller->getRequest()->getServer('HTTP_REFERER', ''), 0, mb_strlen($validHost) ) ){
			throw new Exception('AJAX referer');
		}
	}
}