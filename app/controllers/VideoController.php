<?php

class VideoController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$videoTable = new App_Model_DbTable_Video();
		$this->view->video = $videoTable->getAll();
	}
}