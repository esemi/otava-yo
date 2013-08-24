<?php

class GuestbookController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Гостевая книга');

		$bookTable = new App_Model_DbTable_Guestbook();
		$this->view->notes = $bookTable->getLast(100);
	}

	public function newAction()
	{

	}
}