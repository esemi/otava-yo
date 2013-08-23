<?php

class App_Model_DbTable_News extends Zend_Db_Table_Abstract
{
	protected $_name = 'news';

	public function getLast($limit)
	{
		$select = $this->select()
				->from($this, array('id','date_publish','title','content'))
				->order("date_publish DESC")
				->limit($limit);
		return $this->fetchAll($select)->toArray();
	}

}
