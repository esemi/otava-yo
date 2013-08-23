<?php

class GuestbookController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Гостевая книга');

		$bookTable = new App_Model_DbTable_Guestbook();
		$this->view->notes = $bookTable->getLast(100);
	}

	public function newPostAction()
	{
		//@TODO moder name check

		$this->view->headTitle('Гостевая книга');
		$this->view->headTitle('Новое сообщение');

		$conf = $this->getFrontController()->getParam('bootstrap')->getOption('recaptcha');
		$this->view->recaptcha = $recaptcha = new Zend_Service_ReCaptcha($conf['pubkey'],$conf['privkey']);

		if( $this->_request->isPost() )
		{
			$bookTable = new App_Model_DbTable_Guestbook();
			$this->view->postData = $postData = $this->_request->getPost();

			if( !$this->_helper->checkCaptcha($recaptcha) ){
				$this->view->errorMessage = 'Текст с изображения введён неверно';
				return;
			}

			$res = $bookTable->validateNewPost($postData);
			if( $res !== true ){
				$this->view->errorMessage = $res;
			}
			$bookTable->addPost($postData);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticIndex',true));
		}
	}
}