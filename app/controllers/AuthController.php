<?php

/*
 * контроллер аутентификации юзера
 *
 */
class AuthController extends Zend_Controller_Action
{

	public function loginAction()
	{
		if( Zend_Auth::getInstance()->hasIdentity() )
		{
			$this->_helper->flashMessenger->addMessage(array( 'success' => "Вы уже вошли в систему. Если вам необходимо зайти под другим ником сперва выйдите.") );
			$this->_helper->redirector->gotoRouteAndExit(array(), 'userProfile', true);
		}

		$mes = $this->_helper->flashMessenger->getMessages();
		if( count($mes) > 0 && is_array($mes) )
		{
			$mes = array_shift($mes);
			$keys = array_keys($mes);
			$this->view->messType = array_shift( $keys );
			$this->view->messText = array_shift( $mes );
		}

		if( $this->_request->isPost() )
		{
			$this->view->login = $login = $this->_request->getPost('login');
			$pass = $this->_request->getPost('pass');

			if( false === $this->_loginUser($login, $pass) )
			{
				$this->view->messType = 'error';
				$this->view->messText = 'Неверная пара логин/пароль';
				return;
			}

			$this->_helper->redirector->gotoUrlAndExit($this->_getParam('return', $this->view->url(array(),'userProfile',true) ));
		}

	}

	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		if( $auth->hasIdentity() )
		{
			Zend_Auth::getInstance()->clearIdentity();
			Zend_Session::forgetMe();
			Zend_Session::expireSessionCookie();
		}
		$this->_helper->redirector->gotoRouteAndExit(array(), 'staticIndex', true);
	}


	protected function _loginUser($login, $pass)
	{
		$auth = Zend_Auth::getInstance();
		$adapter = $this->_getLoginAdapter($login, $pass);
		if( $auth->authenticate($adapter)->isValid() )
		{
			$res = $adapter->getResultRowObject();
			$user = new stdClass();
			$user->id = $res->id;
			$user->login = $res->login;
			$user->role = $res->role;
			$user->csrf = hash('sha256', uniqid( mt_rand(), true ));
			$auth->getStorage()->write($user);
			Zend_Session::rememberMe();
			return true;
		}else{
			return false;
		}
	}

	protected function _getLoginAdapter($login, $pass)
	{
		$db = $this->getInvokeArg('bootstrap')->getResource('db');
		$adapter = new Zend_Auth_Adapter_DbTable($db);
		$adapter->setTableName('users')
				->setIdentityColumn('login')
				->setCredentialColumn('pass')
				->setCredentialTreatment('SHA1( CONCAT( ?, `salt` ) )')
				->setIdentity( (empty($login)) ? ' ' : $login )
				->setCredential( $pass );
		return $adapter;
	}
}