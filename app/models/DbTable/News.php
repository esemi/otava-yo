<?php

/*
 * модель новостей
 */
class App_Model_DbTable_News extends Zend_Db_Table_Abstract
{
	protected $_name = 'news';

	public function getList($page=1, $limit=50)
	{
		$select = $this->select()
				->where('visible = 1')
				->order('date_pub DESC');

		$paginator = Zend_Paginator::factory($select);
		$paginator->setCurrentPageNumber($page)
				->setItemCountPerPage($limit)
				->setPageRange(5);

		return $paginator;
	}

}
