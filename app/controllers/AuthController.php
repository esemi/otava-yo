<?php

/*
 * контроллер аутентификации юзера
 *
 */
class AuthController extends Zend_Controller_Action
{

	public function loginAction()
	{
		if( $this->_request->isPost() )
		{
			$this->view->login = $login = $this->_request->getPost('login', '');
			$pass = $this->_request->getPost('pass', '');
			if( !$this->_login($login, $pass) ){
				$this->view->errorMessage = 'Неверная пара логин/пароль';
				return;
			}
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticIndex'));
		}

	}

	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		if( $auth->hasIdentity() ){
			$this->_logout();
		}
		$this->_helper->redirector->gotoRouteAndExit(array(), 'staticIndex');
	}

	protected function _logout()
	{
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Session::forgetMe();
		Zend_Session::expireSessionCookie();
	}

	protected function _login($login, $pass)
	{
		$auth = Zend_Auth::getInstance();
		$adapter = new Mylib_Auth_Adapter_Simple($login, $pass);
		if( $auth->authenticate($adapter)->isValid() )
		{
			$user = new stdClass();
			$user->login = $login;
			$user->csrf = hash('sha256', uniqid( mt_rand(), true ));
			$auth->getStorage()->write($user);
			Zend_Session::rememberMe();
			return true;
		}else{
			return false;
		}
	}
}
?>