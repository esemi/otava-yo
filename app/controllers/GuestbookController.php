<?php

class GuestbookController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Гостевая книга');

		$bookTable = new App_Model_DbTable_Guestbook();

		$conf = $this->getFrontController()->getParam('bootstrap')->getOption('recaptcha');
		$this->view->recaptcha = $recaptcha = new Zend_Service_ReCaptcha($conf['pubkey'],$conf['privkey']);
		$this->view->showForm = false;

		if( $this->_request->isPost() )
		{
			$postData = $this->_request->getPost();

			if( !$this->_helper->checkCaptcha($recaptcha) ){
				$this->view->errorMessage = 'Текст с изображения введён неверно';
			}else{
				list($validData, $res) = $bookTable->prepareNewPost($postData);
				if( !empty($res) ){
					$this->view->errorMessage = implode('<br>', $res);
				}else{
					$bookTable->addPost($validData['author'], $validData['message'], $validData['email'], $validData['site'], $validData['city']);
				}
			}

			if( !empty($this->view->errorMessage) ){
				$this->view->postData = $postData;
				$this->view->showForm = true;
			}
		}

		$this->view->notes = $bookTable->getAll();
	}
}