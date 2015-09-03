<?php

class App_Model_DbTable_Album extends Zend_Db_Table_Abstract
{
	protected $_name = 'album';


	public function findById($id)
	{
		$select = $this->select()
						->from($this)
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

	public function getAll()
	{
		$select = $this->select()
				->from($this)
				->order('year DESC');
		return $this->fetchAll($select)->toArray();
	}

	/**
	 * Add new album
	 *
	 * @param array $data

	 * @return int Inserted id
	 */
	public function addAlbum($data) {
		return $this->insert($data);
	}

	/**
	 * Edit album
	 *
	 * @param int $id
	 * @param array $data

	 * @return int Count of updated rows
	 */
	public function editAlbum($id, $data) {
		return $this->update($data, array($this->_db->quoteInto('id = ?', $id, Zend_Db::INT_TYPE)));
	}


	/**
	 * Delete album
	 *
	 * @param int $id

	 * @return int Count of deleted rows
	 */
	public function delAlbum($id)
	{
		return $this->delete( array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}
}
