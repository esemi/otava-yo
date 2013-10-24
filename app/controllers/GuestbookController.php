<?php

class GuestbookController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$bookTable = new App_Model_DbTable_Guestbook();

		$moderFlag = $this->_helper->checkAccess();

		$conf = $this->getFrontController()->getParam('bootstrap')->getOption('recaptcha');
		$this->view->recaptcha = $recaptcha = new Zend_Service_ReCaptcha($conf['pubkey'],$conf['privkey']);
		$this->view->showForm = false;

		if( $this->_request->isPost() )
		{
			$postData = $this->_request->getPost();

			if( $moderFlag === true ){
				$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));
			}

			if( $moderFlag === false &&
				!$this->_helper->checkCaptcha($recaptcha)
			){
				$this->view->errorMessage = 'Текст с изображения введён неверно';
			}else{
				list($validData, $res) = $bookTable->validate($postData, $moderFlag);
				if( !empty($res) ){
					$this->view->errorMessage = implode('<br>', $res);
				}else{
					$bookTable->addPost($validData['author'], $validData['content'], $validData['email'], $validData['site'], $validData['city']);
				}
			}

			if( !empty($this->view->errorMessage) ){
				$this->view->postData = $postData;
				$this->view->showForm = true;
			}
		}

		$this->view->notes = $bookTable->getAll();
	}

	public function parserAction()
	{
		$bookTable = new App_Model_DbTable_Guestbook();
		$posts = file(realpath(APPLICATION_PATH . '/../docs/old_guestbook_parser/result.csv'));
		var_dump(count($posts));
		foreach ($posts as $post){
			$postArr = explode("\t", $post);
			$postData = array(
				'email' => trim($postArr[5]),
				'site' => trim($postArr[4]),
				'city' => trim($postArr[1]),
				'author' => trim($postArr[2]),
				'content' => trim($postArr[0]),
			);
			list($validData, $res) = $bookTable->validate($postData, true);

			if( !empty($res) ){
				var_dump($postData, $res);
			}else{
				$bookTable->addPost($validData['author'], $validData['content'], $validData['email'], $validData['site'], $validData['city'], $postArr[3]);
			}
		}
		die;
	}

	public function deleteAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$bookTable = new App_Model_DbTable_Guestbook();

		$bookData = $bookTable->findById((int) $this->_getParam('idP',0));
		if( is_null($bookData) ){
			throw new Mylib_Exception_NotFound('Post not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$bookTable->delPost($bookData['id']);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticGuestbook'));
		}
	}

	public function editAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$bookTable = new App_Model_DbTable_Guestbook();

		$bookData = $bookTable->findById((int) $this->_getParam('idP'));
		if( is_null($bookData) ){
			throw new Mylib_Exception_NotFound('Post not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$this->view->postData = $postData = $this->_request->getPost();
			list($validData, $res) = $bookTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$bookTable->editPost($bookData['id'], $validData['author'], $validData['content'], $validData['email'], $validData['site'], $validData['city']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticGuestbook'));
			}
		}else{
			$this->view->postData = $bookData;
		}
	}
}