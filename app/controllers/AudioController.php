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
				$audioModel->addAlbum($validData['content'], $validData['title']);
				$this->_helper->redirector->gotoUrlAndExit($this->view->url(array(),'staticAudio'));
			}
		}
	}
}