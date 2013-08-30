<?php

class AudioController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Аудио');

		$audioModel = new App_Model_Audio();
		$this->view->albums = $audioModel->getAllAlbum();
		$this->view->audio = $audioModel->getAllAudio();
	}
}