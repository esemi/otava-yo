<?php

class AudioController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$audioModel = new App_Model_Audio();
		$this->view->albums = $audioModel->getAllAlbum();
		$this->view->audio = $audioModel->getAllAudio();
	}

	public function getRandAction()
	{
		$this->_helper->forceAjaxRequest();

		$audioModel = new App_Model_Audio();
		$this->view->track = $audioModel->getRandTrack();
	}

	public function albumCreateAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();

		$this->view->albumData = $postData = $this->_request->getPost();

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			list($validData, $res) = $audioModel->albumValidate($postData);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$audioModel->addAlbum($validData['title'], $validData['year'], $validData['album_image'], $validData['desc']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticAudio'));
			}
		}
	}

	public function albumEditAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();

		$albumData = $audioModel->findAlbumById((int) $this->_getParam('idAl'));
		if( is_null($albumData) ){
			throw new Mylib_Exception_NotFound('Album not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$this->view->albumData = $postData = $this->_request->getPost();
			$this->view->albumData['img_link'] = $albumData['img_link'];

			list($validData, $res) = $audioModel->albumValidate($postData, false);
			if( !empty($res) ){
				$this->view->errorMessage = implode('<br>', $res);
			}else{
				$audioModel->editAlbum($albumData['id'], $validData['title'], $validData['year'], $validData['album_image'], $validData['desc']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticAudio'));
			}
		}else{
			$this->view->albumData = $albumData;
		}
	}

	public function albumDeleteAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();
		$albumData = $audioModel->findAlbumById((int) $this->_getParam('idAl'));
		if( is_null($albumData) ){
			throw new Mylib_Exception_NotFound('Album not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$audioModel->delAlbum($albumData['id']);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticAudio'));
		}
	}

	public function playlistEditAction()
	{
		if( !$this->_helper->checkAccess() )
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();

		$albumData = $audioModel->findAlbumById((int) $this->_getParam('idAl'));
		if( is_null($albumData) ){
			throw new Mylib_Exception_NotFound('Album not found');
		}

		if( $this->_request->isPost() )
		{
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));


		}else{
			$this->view->albumData = $albumData;
			//$this->view->playlistData = $albumData;
		}
	}
}