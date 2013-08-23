<?php

class IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headMeta()->appendName('keywords', 'оттава ё, главная, фолк, музыка, группа');
		$this->view->headMeta()->appendName('description', 'Описание этой вашей группы.');
		$this->view->headTitle('Главная страница');

		$concertTable = new App_Model_DbTable_Concert();
		$this->view->concert = $concertTable->getNearest();
	}

	public function bandAction()
	{

	}

	public function contactAction()
	{

	}
}