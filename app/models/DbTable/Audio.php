<?php

class App_Model_DbTable_Audio extends Zend_Db_Table_Abstract
{
	protected $_name = 'audio';

	public function getLastTrack()
	{
		$select = $this->select()
				->from($this, array('id', 'album_id', 'title','media_link'))
				->order('id DESC')
				->limit(1);
		$res = $this->fetchRow($select);
		return is_null($res) ? null : $res->toArray();
	}

}
