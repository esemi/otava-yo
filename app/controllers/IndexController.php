<?php

class IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headMeta()->appendName('keywords', 'оттава ё, главная, фолк, музыка, группа');
		$this->view->headMeta()->appendName('description', 'Описание этой вашей группы.');
		$this->view->headTitle('Главная страница');
	}

	public function bandAction()
	{

	}

	public function contactAction()
	{

	}
}