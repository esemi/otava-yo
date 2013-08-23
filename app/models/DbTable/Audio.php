<?php

class App_Model_DbTable_Audio extends Zend_Db_Table_Abstract
{
	protected $_name = 'audio';

	public function getLastTrack()
	{
		$select = $this->select()
				->from($this, array('id','title','media_link'))
				->order('id DESC')
				->limit(1);
		return $this->fetchRow($select);
	}

}
