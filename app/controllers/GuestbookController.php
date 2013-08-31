<?php

class GuestbookController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Гостевая книга');

		$bookTable = new App_Model_DbTable_Guestbook();
		$this->view->notes = $bookTable->getAll();

		$conf = $this->getFrontController()->getParam('bootstrap')->getOption('recaptcha');
		$this->view->recaptcha = $recaptcha = new Zend_Service_ReCaptcha($conf['pubkey'],$conf['privkey']);
		$this->view->postData = $postData = $this->_request->getPost();
		$this->view->errorMessage = '';

		if( $this->_request->isPost() )
		{
			if( !$this->_helper->checkCaptcha($recaptcha) ){
				$this->view->errorMessage = 'Текст с изображения введён неверно';
				return;
			}

			list($validData, $res) = $bookTable->prepareNewPost($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$bookTable->addPost($validData['author'], $validData['message'], $validData['email'], $validData['site'], $validData['city']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticGuestbook',true));
			}
		}
	}
}