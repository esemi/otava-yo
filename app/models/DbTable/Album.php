<?php

class App_Model_DbTable_Album extends Zend_Db_Table_Abstract
{
	protected $_name = 'album';


	public function findById($id)
	{
		$select = $this->select()
						->from($this, array( 'id', 'title', 'year', 'desc' ))
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

	public function getAll()
	{
		$select = $this->select()
				->from($this, array('id', 'title', 'year', 'desc'))
				->order('year DESC');
		return $this->fetchAll($select)->toArray();
	}

	/**
	 * Add new album
	 *
	 * @param string $title
	 * @param string $year
	 * @param string $desc

	 * @return int Inserted id
	 */
	public function addAlbum($title, $year, $desc='')
	{
		return $this->insert( array(
			'title' => $title,
			'year' => $year,
			'desc' => $desc ));
	}

	/**
	 * Edit album
	 *
	 * @param int $id
	 * @param string $title
	 * @param string $year
	 * @param string $desc

	 * @return int Count of updated rows
	 */
	public function editAlbum($id, $title, $year, $desc='')
	{
		return $this->update(
			array( 'title' => $title, 'year' => $year, 'desc' => $desc ),
			array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
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
