<?php

class App_Model_DbTable_Concert extends Zend_Db_Table_Abstract
{
	protected $_name = 'concert';

	public function getNearest()
	{
		$select = $this->select()
				->where('`date` >= CURDATE()')
				->order("date ASC")
				->limit(1);
		$this->_addMainFields($select);
		return $this->fetchRow($select);
	}

	public function getHereAfter()
	{
		$select = $this->select()
				->where('`date` >= CURDATE()')
				->order("date ASC");
		$this->_addMainFields($select);
		return $this->fetchAll($select);
	}


	public function getHereBefore()
	{
		$select = $this->select()
				->where('`date` < CURDATE()')
				->order("date DESC");
		$this->_addMainFields($select);
		return $this->fetchAll($select);
	}

	protected function _addMainFields($select)
	{
		$select->from($this, array('id','title','link','desc','date', 'place', 'time' => 'TIME_FORMAT(`time`, "%H:%i")', 'cost'));
	}
}
