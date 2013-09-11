<?php

class Action_Helper_TitleSetter extends Zend_Controller_Action_Helper_Abstract
{

	public function postDispatch()
	{
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$req = $this->getRequest();
		$viewRenderer->view->headTitle( $viewRenderer->view->translate(sprintf('title.%s.%s', $req->getControllerName(), $req->getActionName())) );
	}
}