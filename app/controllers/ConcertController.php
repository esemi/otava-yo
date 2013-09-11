<?php

class ConcertController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$concertTable = new App_Model_DbTable_Concert();
		$this->view->concerts = $concertTable->getHereAfter();
		$this->view->oldConcerts = $concertTable->getHereBefore();
	}
}