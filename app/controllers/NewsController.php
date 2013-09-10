<?php

class NewsController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$newsTable = new App_Model_DbTable_News();
		$this->view->news = $newsTable->getAll();

		$this->view->moder_author = $this->getFrontController()->getParam('bootstrap')->getOption('guestbook_reserved_name');
	}


	public function createAction()
	{
		$newsTable = new App_Model_DbTable_News();

		$this->view->newsData = $postData = $this->_request->getPost();

		if( $this->_request->isPost() )
		{
			list($validData, $res) = $newsTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$newsTable->addPost($validData['content'], $validData['title']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticNews'));
			}
		}
	}

	public function editAction()
	{
		$newsTable = new App_Model_DbTable_News();

		$newsData = $newsTable->findById((int) $this->_getParam('idN'));
		if( is_null($newsData) ){
			throw new Mylib_Exception_NotFound('News not found');
		}

		if( $this->_request->isPost() )
		{
			$this->view->newsData = $postData = $this->_request->getPost();
			list($validData, $res) = $newsTable->validate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$newsTable->editPost($newsData['id'], $validData['content'], $validData['title']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array('id' => $newsData['id']),'staticNewsView'));
			}
		}else{
			$this->view->newsData = $newsData;
		}
	}

	public function deleteAction()
	{
		$newsTable = new App_Model_DbTable_News();

		$newsData = $newsTable->findById((int) $this->_getParam('idN'));
		if( is_null($newsData) ){
			throw new Mylib_Exception_NotFound('News not found');
		}

		if( $this->_request->isPost() )
		{
			$newsTable->delPost($newsData['id']);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array('id' => $newsData['id']),'staticNewsView'));
		}
	}

}