<?php

class App_Model_DbTable_Concert extends Zend_Db_Table_Abstract
{
	protected $_name = 'concert';

	public function getNearest()
	{
		$select = $this->select()
				->from($this, array('id','title','link','desc','date'))
				->where('`date` >= CURDATE()')
				->order("date ASC")
				->limit(1);
		return $this->fetchRow($select);
	}

}
