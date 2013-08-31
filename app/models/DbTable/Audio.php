<?php

class App_Model_DbTable_Audio extends Zend_Db_Table_Abstract
{
	protected $_name = 'audio';

	public function getRand()
	{
		$select = $this->select()
				->from($this, array('id', 'album_id', 'title'))
				->order('RAND()') // only for little table
				->limit(1);
		$res = $this->fetchRow($select);
		return is_null($res) ? null : $res->toArray();
	}

	public function getAll()
	{
		$select = $this->select()
				->from($this, array('id', 'album_id', 'title'))
				->order('album_id');
		return $this->fetchAll($select)->toArray();
	}

}
