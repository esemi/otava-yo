<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initOthers()
	{
		$this->bootstrap('cachemanager');
		Zend_Db_Table_Abstract::setDefaultMetadataCache( $this->getResource('cachemanager')->getCache('long') );
		Zend_Translate::setCache( $this->getResource('cachemanager')->getCache('long') );

		Zend_Paginator::setDefaultScrollingStyle('Elastic');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('Partials/pagination.phtml');

		Zend_Session::registerValidator( new Zend_Session_Validator_HttpUserAgent() );
		Zend_Session::registerValidator( new Mylib_Session_Validator_IPAdress() );

		$this->bootstrap('frontcontroller');
		Zend_Controller_Action_HelperBroker::getStaticHelper('CheckLocale');
	}

	protected function _initRoute()
	{
		$router = Zend_Controller_Front::getInstance()->getRouter();
		$router->removeDefaultRoutes();
		$router->addRoute('default', new Zend_Controller_Router_Route('*', array('controller' => 'default-router-fail')));

		$locales = $this->getOption('locales');

		$langRoute = new Zend_Controller_Router_Route('/:lang',
			array( 'lang' => $locales[0] ),
			array( 'lang' => sprintf('(%s)', implode('|', $locales)) ));

		$routes = array();

		$routes['staticIndex'] = new Zend_Controller_Router_Route_Static('/', array( 'controller' => 'index', 'action' => 'index'));
		$routes['staticBand'] = new Zend_Controller_Router_Route_Static('/band', array( 'controller' => 'index', 'action' => 'band' ));
		$routes['staticContacts'] = new Zend_Controller_Router_Route_Static('/contacts', array( 'controller' => 'index', 'action' => 'contact' ));
		$routes['staticNews'] = new Zend_Controller_Router_Route_Static('/news', array( 'controller' => 'news', 'action' => 'index' ));
		$routes['staticNewsCreate'] = new Zend_Controller_Router_Route_Static('/news/create', array( 'controller' => 'news', 'action' => 'create' ));
		$routes['staticNewsEdit'] = new Zend_Controller_Router_Route('/news/edit/:idN/', array( 'controller' => 'news', 'action' => 'edit' ), array( 'idN' => '\d+' ));
		$routes['staticNewsDelete'] = new Zend_Controller_Router_Route('/news/delete/:idN', array( 'controller' => 'news', 'action' => 'delete' ), array( 'idN' => '\d+' ));
		$routes['staticNewsView'] = new Zend_Controller_Router_Route_Regex('/news\#view(\d+)', array( 'controller' => 'news', 'action' => 'index'), array( 'id' => 1), 'news#view%d');
		$routes['staticConcert'] = new Zend_Controller_Router_Route_Static('/concerts', array( 'controller' => 'concert', 'action' => 'index' ));
		$routes['staticConcertView'] = new Zend_Controller_Router_Route_Regex('/concerts\#view(\d+)', array( 'controller' => 'concert', 'action' => 'index'), array( 'id' => 1), 'concerts#view%d');
		$routes['staticGuestbook'] = new Zend_Controller_Router_Route_Static('/guestbook', array( 'controller' => 'guestbook', 'action' => 'index' ));
		$routes['staticVideo'] = new Zend_Controller_Router_Route_Static('/video', array( 'controller' => 'video', 'action' => 'index' ));
		$routes['staticAudio'] = new Zend_Controller_Router_Route_Static('/audio', array( 'controller' => 'audio', 'action' => 'index' ));
		$routes['staticDonate'] = new Zend_Controller_Router_Route_Static('/donate', array( 'controller' => 'index', 'action' => 'donate' ));
		$routes['login'] = new Zend_Controller_Router_Route_Static('/auth/login', array( 'controller' => 'auth', 'action' => 'login' ));
		$routes['logout'] = new Zend_Controller_Router_Route_Static('/auth/logout', array( 'controller' => 'auth', 'action' => 'logout' ));

		foreach( $routes as $name => $route ){
			$router->addRoute($name, $langRoute->chain($route));
		}
	}
}