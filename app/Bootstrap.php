<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initOthers()
	{
		$this->bootstrap('cachemanager');
		Zend_Db_Table_Abstract::setDefaultMetadataCache( $this->getResource('cachemanager')->getCache('long') );
		Zend_Paginator::setDefaultScrollingStyle('Elastic');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('Partials/pagination.phtml');

		Zend_Session::registerValidator( new Zend_Session_Validator_HttpUserAgent() );
		Zend_Session::registerValidator( new Mylib_Session_Validator_IPAdress() );
	}
}