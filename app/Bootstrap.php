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

	protected function _initRoute()
	{
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();

		$router->removeDefaultRoutes();

		$router->addRoute('staticIndex',
				new Zend_Controller_Router_Route_Static('/',
						array( 'controller' => 'index', 'action' => 'index' )));
		$router->addRoute('staticBand',
				new Zend_Controller_Router_Route_Static('/band.html',
						array( 'controller' => 'index', 'action' => 'band' )));
		$router->addRoute('staticContacts',
				new Zend_Controller_Router_Route_Static('/contacts.html',
						array( 'controller' => 'index', 'action' => 'contact' )));
		$router->addRoute('staticNews',
				new Zend_Controller_Router_Route_Static('/news.html',
						array( 'controller' => 'news', 'action' => 'index' )));
		$router->addRoute('staticConcert',
				new Zend_Controller_Router_Route_Static('/concerts.html',
						array( 'controller' => 'concert', 'action' => 'index' )));
	}

}