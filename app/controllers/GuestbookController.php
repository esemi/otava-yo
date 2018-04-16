<?php

class GuestbookController extends Zend_Controller_Action
{
	public function indexAction() {
		$bookTable = new App_Model_DbTable_Guestbook();
		$moderFlag = $this->_helper->checkAccess();
		$this->view->showForm = false;

		if( $this->_request->isPost() ){
			$postData = $this->_request->getPost();
			if ($moderFlag) {
				$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));
			}

			list($validData, $res) = $bookTable->validate($postData, $moderFlag);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$bookTable->addPost(
						$validData['author'],
						$validData['content'],
						$validData['email'],
						$validData['site'],
						$validData['city'],
						$validData['parent_id']
				);
			}

			if( !empty($this->view->errorMessage) ){
				$this->view->postData = $postData;
				$this->view->showForm = true;
			}
		}

		$this->view->notes = $bookTable->getAllNotes();
		$this->view->replyes = $bookTable->getAllReplyes();
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