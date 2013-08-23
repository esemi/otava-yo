<?php

class ConcertController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->headTitle('Концерты');
	}
}