<?php

class NewsController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->view->page = $page = intval($this->_getParam('page'));
		$this->view->news = $this->_helper->modelLoad('News')->getList($page);
	}
}