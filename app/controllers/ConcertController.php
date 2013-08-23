<?php

class ConcertController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Концерты');

		$concertTable = new App_Model_DbTable_Concert();
		$this->view->concerts = $concertTable->getHereAfter();
	}
}