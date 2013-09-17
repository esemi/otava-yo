<?php

class ConcertController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$concertTable = new App_Model_DbTable_Concert();
		$this->view->concerts = $concertTable->getHereAfter();
		$this->view->oldConcerts = $concertTable->getHereBefore();
	}

	public function createAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$concertTable = new App_Model_DbTable_Concert();

		$this->view->concertData = $postData = $this->_request->getPost();

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));
			
			list($validData, $res) = $concertTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$concertTable->addConcert($validData);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticConcert'));
			}
		}
	}

	public function editAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$concertTable = new App_Model_DbTable_Concert();

		$concertData = $concertTable->findById((int) $this->_getParam('idC'));
		if( is_null($concertData) ){
			throw new Mylib_Exception_NotFound('Concert not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$this->view->concertData = $postData = $this->_request->getPost();
			list($validData, $res) = $concertTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$concertTable->editConcert($concertData['id'], $validData);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array('id' => $concertData['id']),'staticConcertView'));
			}
		}else{
			$this->view->concertData = $concertData;
		}
	}

	public function deleteAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$concertTable = new App_Model_DbTable_Concert();

		$concertData = $concertTable->findById((int) $this->_getParam('idC'));
		if( is_null($concertData) ){
			throw new Mylib_Exception_NotFound('Concert not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$concertTable->delConcert($concertData['id']);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array('id' => $concertData['id']),'staticConcertView'));
		}
	}
}