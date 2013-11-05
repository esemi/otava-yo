<?php

class ErrorController extends Zend_Controller_Action
{
	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');
		$uri = $this->_request->getRequestUri();

		$notFoundTypes = array(
			Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE,
			Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER,
			Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION
		);

		if( in_array($errors->type, $notFoundTypes) || $errors->exception instanceof Mylib_Exception_NotFound) {

			$this->getResponse()->setHttpResponseCode(404);
			$this->view->message = $this->view->translate('errors.404');
			$this->getInvokeArg('bootstrap')->getResource('Log')->notice($errors->exception->getMessage() . $uri);

		}elseif( $errors->exception instanceof Mylib_Exception_Forbidden ){

			$this->getResponse()->setHttpResponseCode(403);
			$this->view->message = $this->view->translate('errors.403');
			$this->getInvokeArg('bootstrap')->getResource('Log')->crit($errors->exception->getMessage() . $uri);

		}else{

			$this->getResponse()->setHttpResponseCode(500);
			$this->view->message = $this->view->translate('errors.500');
			$this->getInvokeArg('bootstrap')->getResource('Log')->crit($errors->exception->getMessage() . $uri);

		}

		if ($this->getInvokeArg('displayExceptionMessage') == true)
			$this->view->exceptionMessage = $errors->exception->getMessage();


		if ($this->getInvokeArg('displayExceptions') == true)
			$this->view->exception = $errors->exception;

		$this->view->request = $errors->request;
	}
}