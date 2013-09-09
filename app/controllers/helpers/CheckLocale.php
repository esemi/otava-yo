<?php

class Action_Helper_CheckLocale extends Zend_Controller_Action_Helper_Abstract
{

	public function preDispatch()
	{
		$avaliableLangs =  $this->getFrontController()->getParam('bootstrap')->getOption('locales');
		$lang = $this->getRequest()->getParam('lang');

		if( in_array($lang, $avaliableLangs) ){
			$translate = $this->getActionController()->getInvokeArg('bootstrap')->getResource('Translate');

			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
			var_dump($translate->getAdapter()->setLocale($lang), $viewRenderer->view->translate('menu.index'));die;
		}
	}
}