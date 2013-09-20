<?php

class IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$concertTable = new App_Model_DbTable_Concert();
		$this->view->concert = $concertTable->getNearest();

		$audioModel = new App_Model_Audio();
		$this->view->audio = $audioModel->getRandTrack();

		$newsTable = new App_Model_DbTable_News();
		$news = $newsTable->getLast(1)->current();

		$news->content = $newsTable->stripContent($news->content, 350);
		$this->view->news = $news;
	}

	public function bandAction()
	{
	}

	public function contactAction()
	{
	}

	public function donateAction()
	{
	}
}