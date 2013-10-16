<?php

class Action_Helper_CheckLocale extends Zend_Controller_Action_Helper_Abstract
{

	public function init()
	{
		$avaliableLangs =  $this->getFrontController()->getParam('bootstrap')->getOption('locales');
		$lang = $this->getRequest()->getParam('lang');
		if( !in_array($lang, $avaliableLangs) ){
			$lang = $avaliableLangs[0];
		}

		//ru-RU, ru, en-US, en
		$oTranslate = $this->getActionController()->getInvokeArg('bootstrap')->getResource('Translate');
		$oTranslate->getAdapter()->setLocale($lang);
		$oTranslate->getAdapter()->setOptions( array('log' => $this->getActionController()->getInvokeArg('bootstrap')->getResource('Log')) );
	}
}