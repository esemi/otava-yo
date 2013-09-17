<?php

class VideoController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$videoTable = new App_Model_DbTable_Video();
		$this->view->video = $videoTable->getAll();
	}

	public function createAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$videoTable = new App_Model_DbTable_Video();

		$this->view->videoData = $postData = $this->_request->getPost();

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			list($validData, $res) = $videoTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$videoTable->addVideo($validData['player_code'], $validData['desc']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticVideo'));
			}
		}
	}

	public function editAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$videoTable = new App_Model_DbTable_Video();

		$videoData = $videoTable->findById((int) $this->_getParam('idV'));
		if( is_null($videoData) ){
			throw new Mylib_Exception_NotFound('Video not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$this->view->videoData = $postData = $this->_request->getPost();
			list($validData, $res) = $videoTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$videoTable->editVideo($videoData['id'], $validData['player_code'], $validData['desc']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticVideo'));
			}
		}else{
			$this->view->videoData = $videoData;
		}
	}

	public function deleteAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();


		$videoTable = new App_Model_DbTable_Video();

		$videoData = $videoTable->findById((int) $this->_getParam('idV'));
		if( is_null($videoData) ){
			throw new Mylib_Exception_NotFound('Video not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$videoTable->delVideo($videoData['id']);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticVideo'));
		}
	}
}