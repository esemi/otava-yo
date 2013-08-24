<?php

class Mylib_Auth_Adapter_Simple implements Zend_Auth_Adapter_Interface
{
	protected
			$_login,
			$pass;

	public function __construct($login, $pass)
	{
		$this->_login = $login;
		$this->_pass = $pass;
	}

	public function authenticate()
	{
		$validProps = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('moderator_auth');

		if( $validProps['login'] !== $this->_login ){
			$result = new Zend_Auth_Result(
				Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
				$this->_login,
				array('Unknown user!'));
		}elseif( $validProps['pass'] !== $this->_pass ){
			$result =  new Zend_Auth_Result(
				Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
				$this->_login,
				array('Bad password!'));
		}else{
			$result =  new Zend_Auth_Result(
				Zend_Auth_Result::SUCCESS,
				$this->_login);
		}

		return $result;
	}
}
