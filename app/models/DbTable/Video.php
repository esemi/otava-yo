<?php

class App_Model_DbTable_Video extends Zend_Db_Table_Abstract
{
	protected $_name = 'video';

	public function findById($id)
	{
		$select = $this->select()
						->from($this, array( 'id','player_code','desc' ))
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

	public function getAll()
	{
		$select = $this->select()
				->from($this, array('id','player_code','desc'))
				->order("id DESC");
		return $this->fetchAll($select);
	}

	public function validate($data)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'desc' => '',
			'player_code' => '',
		);

		if( !empty($data['desc']) ){
			if( mb_strlen($data['desc']) > 1024 ){
				$errors[] = 'Слишком длинный заголовок';
			}else{
				$validData['desc'] = $data['desc'];
			}
		}

		if( empty($data['player_code']) ){
			$errors[] = 'Код видео не может быть пустым';
		}else{
			$validData['player_code'] = $data['player_code'];
		}

		return array($validData, $errors);
	}

	/**
	 * Add new video
	 *
	 * @param string $code
	 * @param string $desc

	 * @return int Count of inserted rows
	 */
	public function addVideo($code, $desc='')
	{
		return $this->insert( array(
			'player_code' => $code,
			'desc' => $desc ));
	}

	/**
	 * Edit video
	 *
	 * @param int $id
	 * @param string $code
	 * @param string $desc

	 * @return int Inserted id
	 */
	public function editVideo($id, $code, $desc='')
	{
		return $this->update(
			array( 'player_code' => $code, 'desc' => $desc ),
			array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}

	/**
	 * Delete video
	 *
	 * @param int $id

	 * @return int Count of deleted rows
	 */
	public function delVideo($id)
	{
		return $this->delete( array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}

}