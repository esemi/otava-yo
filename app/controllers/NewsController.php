<?php

class NewsController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Новости');

		$newsTable = new App_Model_DbTable_News();
		$this->view->news = $newsTable->getAll();

		$this->view->moder_author = $this->getFrontController()->getParam('bootstrap')->getOption('guestbook_reserved_name');
	}
}