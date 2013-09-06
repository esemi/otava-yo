<?php

class IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headMeta()->appendName('keywords', 'оттава ё, главная, фолк, музыка, группа');
		$this->view->headMeta()->appendName('description', 'Описание этой вашей группы.');
		$this->view->headTitle('Главная');

		$concertTable = new App_Model_DbTable_Concert();
		$this->view->concert = $concertTable->getNearest();

		$audioModel = new App_Model_Audio();
		$this->view->audio = $audioModel->getRandTrack();

		$newsTable = new App_Model_DbTable_News();
		$news = $newsTable->getLast(1)->current();

		$news->content = $newsTable->stripContent($news->content, 400);
		$this->view->news = $news;
	}

	public function bandAction()
	{
		$this->view->headTitle('О группе');
	}

	public function contactAction()
	{
		$this->view->headTitle('Контакты');
	}

	public function donateAction()
	{
		$this->view->headTitle('Поддержать проект');
	}
}