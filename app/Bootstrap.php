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
				new Zend_Controller_Router_Route_Static('/band',
						array( 'controller' => 'index', 'action' => 'band' )));
		$router->addRoute('staticContacts',
				new Zend_Controller_Router_Route_Static('/contacts',
						array( 'controller' => 'index', 'action' => 'contact' )));

		$router->addRoute('staticNews',
				new Zend_Controller_Router_Route_Static('/news',
						array( 'controller' => 'news', 'action' => 'index' )));
		$router->addRoute('staticNewsView',
				new Zend_Controller_Router_Route_Regex('/news\#view(\d+)',
						array( 'controller' => 'news', 'action' => 'index'),
						array( 'id' => 1),
						'news#view%d'));
		$router->addRoute('staticNewsCreate',
				new Zend_Controller_Router_Route_Static('/news/create',
						array( 'controller' => 'news', 'action' => 'create' )));
		$router->addRoute('staticNewsEdit',
				new Zend_Controller_Router_Route('/news/edit/:idN/',
						array( 'controller' => 'news', 'action' => 'edit' ),
						array( 'idN' => '\d+' )));
		$router->addRoute('staticNewsDelete',
				new Zend_Controller_Router_Route('/news/delete/:idN',
						array( 'controller' => 'news', 'action' => 'delete' ),
						array( 'idN' => '\d+' )));

		$router->addRoute('staticConcert',
				new Zend_Controller_Router_Route_Static('/concerts',
						array( 'controller' => 'concert', 'action' => 'index' )));
		$router->addRoute('staticConcertView',
				new Zend_Controller_Router_Route_Regex('/concerts\#view(\d+)',
						array( 'controller' => 'concert', 'action' => 'index'),
						array( 'id' => 1),
						'concerts#view%d'));
		$router->addRoute('staticGuestbook',
				new Zend_Controller_Router_Route_Static('/guestbook',
						array( 'controller' => 'guestbook', 'action' => 'index' )));
		$router->addRoute('staticVideo',
				new Zend_Controller_Router_Route_Static('/video',
						array( 'controller' => 'video', 'action' => 'index' )));
		$router->addRoute('staticAudio',
				new Zend_Controller_Router_Route_Static('/audio',
						array( 'controller' => 'audio', 'action' => 'index' )));
		$router->addRoute('staticDonate',
				new Zend_Controller_Router_Route_Static('/donate',
						array( 'controller' => 'index', 'action' => 'donate' )));

		$router->addRoute('login',
				new Zend_Controller_Router_Route_Static('/auth/login',
						array( 'controller' => 'auth', 'action' => 'login' )));
		$router->addRoute('logout',
				new Zend_Controller_Router_Route_Static('/auth/logout',
						array( 'controller' => 'auth', 'action' => 'logout' )));

	}

}