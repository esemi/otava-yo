<?php

class App_Model_DbTable_Album extends Zend_Db_Table_Abstract
{
	protected $_name = 'album';

	public function getAlbumById($id)
	{
		$select = $this->select()
				->from($this, array('id','title'))
				->where('id = ?', $id);

		return $this->fetchRow($select)->toArray();
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
}
