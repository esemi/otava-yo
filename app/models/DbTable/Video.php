<?php

class App_Model_DbTable_Video extends Zend_Db_Table_Abstract
{
	protected $_name = 'video';

	public function getAll()
	{
		$select = $this->select()
				->from($this, array('id','player_code','title'))
				->order("id DESC");
		return $this->fetchAll($select);
	}
}