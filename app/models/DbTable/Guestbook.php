<?php

class App_Model_DbTable_Guestbook extends Zend_Db_Table_Abstract
{
	protected $_name = 'guestbook';

	public function getLast($limit)
	{
		$select = $this->select()
				->from($this, array('id', 'author', 'date_publish','email', 'city', 'site', 'content'))
				->order("date_publish DESC")
				->limit($limit);
		return $this->fetchAll($select);
	}

	public function validateNewPost($data)
	{
		
	}

}
