<?php

class Action_Helper_ForceAjaxRequest extends Zend_Controller_Action_Helper_Abstract
{
	//@todo logging
	public function direct()
	{
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$controller = $this->getActionController();

		$controller->getHelper('AjaxContext')
							->addActionContext($this->getRequest()->getActionName(), 'json')
							->initContext('json');


		if( !$controller->getRequest()->isXmlHttpRequest() ){
			throw new Exception('AJAX only');
		}

		$validHost = $viewRenderer->view->serverUrl();
		if( $validHost !== mb_substr($controller->getRequest()->getServer('HTTP_REFERER', ''), 0, mb_strlen($validHost) ) ){
			throw new Exception('AJAX referer');
		}
	}
}