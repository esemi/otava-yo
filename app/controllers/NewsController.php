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


	public function createAction()
	{
		$this->view->headTitle('Новости');
		$this->view->headTitle('Создание');

		// @todo release
	}

	public function editAction()
	{
		$this->view->headTitle('Новости');
		$this->view->headTitle('Редактирование');

		// @todo release
	}

	public function deleteAction()
	{
		$this->view->headTitle('Новости');
		$this->view->headTitle('Удаление');

		// @todo release
	}

}