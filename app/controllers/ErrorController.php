<?php

class ErrorController extends Zend_Controller_Action
{
	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');

		$notFoundTypes = array(
			Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE,
			Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER,
			Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION
		);

		if( in_array($errors->type, $notFoundTypes) || $errors->exception instanceof Mylib_Exception_NotFound)
		{
			$this->_setNotFoundMeta();
			$this->getInvokeArg('bootstrap')->getResource('Log')->notice($errors->exception->getMessage());
		}else{
			$this->_setFatalErrorMeta();
			$this->getInvokeArg('bootstrap')->getResource('Log')->crit($errors->exception->getMessage());
		}

		if ($this->getInvokeArg('displayExceptionMessage') == true)
			$this->view->exceptionMessage = $errors->exception->getMessage();


		if ($this->getInvokeArg('displayExceptions') == true)
			$this->view->exception = $errors->exception;

		$this->view->request = $errors->request;
	}

	protected function _setNotFoundMeta()
	{
		$this->getResponse()->setHttpResponseCode(404);
		$this->view->keywords = '404, Страница не найдена';
		$this->view->description = 'Страница не найдена';
		$this->view->title = 'Страница не найдена';
		$this->view->message = 'Страница не найдена';
	}

	protected function _setFatalErrorMeta()
	{
		$this->getResponse()->setHttpResponseCode(500);
		$this->view->keywords = 'Ошибка, Error';
		$this->view->description = 'Ошибка приложения';
		$this->view->title = 'Ошибка приложения';
		$this->view->message = 'Ошибка приложения';
	}
}