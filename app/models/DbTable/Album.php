<?php

class App_Model_DbTable_Album extends Zend_Db_Table_Abstract
{
	protected $_name = 'album';

	public function getAlbumById($id)
	{
		$select = $this->select()
				->from($this, array('id','title'))
				->where('id = ?', $id);
		
		return $this->fetchRow($select);
	}

}