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
				->order('sort_index');
		return $this->fetchAll($select)->toArray();
	}


	public function findByAlbumId($albumId)
	{
		$select = $this->select()
						->from($this, array('id', 'title'))
						->where('album_id = ?', $albumId, Zend_Db::INT_TYPE)
						->order('sort_index');
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

	/**
	 * Edit track title
	 *
	 * @param int $id
	 * @param string $title

	 * @return int Count of updated rows
	 */
	public function updTrackTitle($id, $title)
	{
		return $this->update(
			array( 'title' => $title ),
			array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}
	/**
	 * Edit track sort index
	 *
	 * @param int $id
	 * @param string $title

	 * @return int Count of updated rows
	 */
	public function updTrackSortIndex($id, $title)
	{
		return $this->update(
			array( 'sort_index' => $title ),
			array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}

	/**
	 * Add new track
	 *
	 * @param int $albumId
	 * @param string $title

	 * @return int Inserted id
	 */
	public function addTrack($albumId, $title)
	{
		return $this->insert( array(
			'title' => $title,
			'album_id' => $albumId,
			'sort_index' => 999 ));
	}

}
