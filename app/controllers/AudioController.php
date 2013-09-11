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
}