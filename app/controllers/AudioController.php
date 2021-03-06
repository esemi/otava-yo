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

	public function removeTrackAction()
	{
		$this->_helper->forceAjaxRequest();

		$this->_helper->csrfTokenCheck($this->_request->getPost('csrfToken'));

		if (!$this->_helper->checkAccess()) {
			$this->view->status = 'error';
			$this->view->error = 'access denied';
			return;
		}

		$audioModel = new App_Model_Audio();
		$audioModel->removeTrack((int) $this->_request->getPost('idTrack', 0));

		$this->view->status = 'success';
	}

	public function sortPlaylistAction()
	{
		$this->_helper->forceAjaxRequest();

		$this->_helper->csrfTokenCheck($this->_request->getPost('csrfToken'));

		if (!$this->_helper->checkAccess()) {
			$this->view->status = 'error';
			$this->view->error = 'access denied';
			return;
		}

		$list = $this->_request->getPost('list');
		if( !is_array($list) ){
			$this->view->status = 'error';
			$this->view->error = 'invalid params';
			return;
		}

		$audioModel = new App_Model_Audio();
		foreach( $list as $index => $id ){
			$audioModel->updTrackSortIndex((int) $id, $index);
		}

		$this->view->status = 'success';
	}

	public function trackEditAction()
	{
		if (!$this->_helper->checkAccess())
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();

		$trackData = $audioModel->findTrackById((int) $this->_getParam('idT'));
		if (is_null($trackData)) {
			throw new Mylib_Exception_NotFound('Track not found');
		}

		if ($this->_request->isPost()) {
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$this->view->trackData = $postData = $this->_request->getPost();

			$errors = array();
			list($title, $res) = $audioModel->validateTrackTitle($this->_request->getPost('title', ''));
			$errors = array_merge($errors, $res);

			list($audioSrc, $res) = $audioModel->validateTrackAudiofile('audiofile_src', false);
			$errors = array_merge($errors, $res);

			if (!empty($errors)) {
				$this->view->errorMessage = implode('<br>', $errors);
			} else {
				$audioModel->updTrackTitle($trackData['id'], $title);
				if( !empty($audioSrc) ){
					$audioModel->editAudioFile($trackData['id'], $audioSrc);
				}
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(), 'staticAudio'));
			}
		} else {
			$this->view->trackData = $trackData;
		}
	}

	public function addTrackAction()
	{
		$this->_helper->forceAjaxRequest();

		$this->_helper->csrfTokenCheck($this->_request->getPost('csrfToken'));

		if (!$this->_helper->checkAccess()) {
			$this->view->status = 'error';
			$this->view->error = 'access denied';
			return;
		}

		$audioModel = new App_Model_Audio();

		$albumData = $audioModel->findAlbumById((int) $this->_request->getPost('albumId'));
		if (is_null($albumData)) {
			$this->view->status = 'error';
			$this->view->error = 'album not found';
			return;
		}

		list($title, $errors) = $audioModel->validateTrackTitle($this->_request->getPost('title'));
		if( count($errors) === 0 ){
			$id = $audioModel->addTrack($albumData['id'], $title);
			$this->view->status = 'success';
			$this->view->track_id = $id;
		}else{
			$this->view->status = 'error';
			$this->view->error = $errors[0];
		}
	}

	public function albumCreateAction()
	{
		if (!$this->_helper->checkAccess())
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();

		$this->view->albumData = $postData = $this->_request->getPost();

		if ($this->_request->isPost()) {
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			list($validData, $res) = $audioModel->albumValidate($postData);
			if (!empty($res)) {
				$this->view->errorMessage = implode('<br>', $res);
			} else {
				$audioModel->addAlbum($validData, $validData['album_image']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(), 'staticAudio'));
			}
		}
	}

	public function albumEditAction()
	{
		if (!$this->_helper->checkAccess())
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();

		$albumData = $audioModel->findAlbumById((int) $this->_getParam('idAl'));
		if (is_null($albumData)) {
			throw new Mylib_Exception_NotFound('Album not found');
		}

		if ($this->_request->isPost()) {
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$this->view->albumData = $postData = $this->_request->getPost();
			$this->view->albumData['img_link'] = $albumData['img_link'];

			list($validData, $res) = $audioModel->albumValidate($postData, false);
			if (!empty($res)) {
				$this->view->errorMessage = implode('<br>', $res);
			} else {
				$audioModel->editAlbum($albumData['id'], $validData, $validData['album_image']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(), 'staticAudio'));
			}
		} else {
			$this->view->albumData = $albumData;
		}
	}

	public function albumDeleteAction()
	{
		if (!$this->_helper->checkAccess())
			throw new Mylib_Exception_Forbidden();

		$audioModel = new App_Model_Audio();
		$albumData = $audioModel->findAlbumById((int) $this->_getParam('idAl'));
		if (is_null($albumData)) {
			throw new Mylib_Exception_NotFound('Album not found');
		}

		if ($this->_request->isPost()) {
			$this->_helper->csrfTokenCheck($this->_request->getPost('csrf'));

			$audioModel->delAlbum($albumData['id']);
			$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(), 'staticAudio'));
		}
	}
}
?>