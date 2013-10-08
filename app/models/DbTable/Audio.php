<?php

class App_Model_DbTable_Audio extends Zend_Db_Table_Abstract
{
	protected $_name = 'audio';

	public function findById($id)
	{
		$select = $this->select()
						->from($this, array('id', 'album_id', 'title'))
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

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
				->order('id');
		return $this->fetchAll($select)->toArray();
	}


	public function findByAlbumId($albumId)
	{
		$select = $this->select()
						->from($this, array('id', 'title'))
						->where('album_id = ?', $albumId, Zend_Db::INT_TYPE);
		return $this->fetchAll($select);
	}

	/**
	 * Delete by  id
	 *
	 * @param int $id

	 * @return int Count of deleted rows
	 */
	public function delById($id)
	{
		return $this->delete( array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}
}
