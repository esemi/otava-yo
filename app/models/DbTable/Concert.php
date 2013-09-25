<?php

class App_Model_DbTable_Concert extends Zend_Db_Table_Abstract
{
	protected $_name = 'concert';

	public function findById($id)
	{
		$select = $this->select()
						->from($this, array('id','title','link','desc','date' => 'DATE_FORMAT(`date`, "%d.%m.%y")', 'place', 'time' => 'TIME_FORMAT(`time`, "%H:%i")', 'cost'))
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

	public function getNearest()
	{
		$select = $this->select()
				->where('`date` >= CURDATE()')
				->order("date ASC")
				->limit(1);
		$this->_addMainFields($select);
		return $this->fetchRow($select);
	}

	public function getHereAfter()
	{
		$select = $this->select()
				->where('`date` >= CURDATE()')
				->order("date ASC");
		$this->_addMainFields($select);
		return $this->fetchAll($select);
	}


	public function getHereBefore()
	{
		$select = $this->select()
				->where('`date` < CURDATE()')
				->order("date DESC");
		$this->_addMainFields($select);
		return $this->fetchAll($select);
	}

	protected function _addMainFields($select)
	{
		$select->from($this, array('id','title','link','desc','date', 'place', 'time' => 'TIME_FORMAT(`time`, "%H:%i")', 'cost'));
	}

	public function validate($data)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'title' => '',
			'desc' => '',
			'cost' => '',
			'place' => '',
			'link' => '',
			'time' => null,
			'date' => '', //required
		);

		if( !empty($data['title']) ){
			if( mb_strlen($data['title']) > 1024 ){
				$errors[] = 'Слишком длинный заголовок';
			}else{
				$validData['title'] = $data['title'];
			}
		}

		if( !empty($data['desc']) ){
			$validData['desc'] = $data['desc'];
		}

		if( !empty($data['cost']) ){
			if( mb_strlen($data['cost']) > 100 ){
				$errors[] = 'Слишком длинное описание цены билетов';
			}else{
				$validData['cost'] = $data['cost'];
			}
		}

		if( !empty($data['place']) ){
			if( mb_strlen($data['place']) > 1024 ){
				$errors[] = 'Слишком длинное место проведения';
			}else{
				$validData['place'] = $data['place'];
			}
		}

		if( !empty($data['link']) )
		{
			$validUrl = new Mylib_Validate_Url();
			$url = 'http://' . str_replace(array('http://', 'https://'), '', $data['link']);
			if( mb_strlen($url) > 1024 || !$validUrl->isValid($url) ){
				$errors[] = 'Некорректная ссылка';
			}else{
				$validData['link'] = $url;
			}
		}

		if( !empty($data['time']) )
		{
			$timeObj = DateTime::createFromFormat('H:i', $data['time']);
			if( $timeObj === false ){
				$errors[] = 'Некорректный формат времени (hh:ii)';
			}else{
				$validData['time'] = $timeObj->format('H:i:00');
			}
		}


		if( empty($data['date']) ){
			$errors[] = 'Не указана дата';
		}else{
			$dateObj = DateTime::createFromFormat('d.m.y', $data['date']);
			if( $dateObj === false ){
				$errors[] = 'Некорректный формат даты (dd.mm.yy)';
			}else{
				$validData['date'] = $dateObj->format('Y-m-d');
			}
		}

		return array($validData, $errors);
	}



	/**
	 * Add new concert
	 *
	 * @param array $params Assoc array contains fields for insert

	 * @return int Inserted id
	 */
	public function addConcert($params)
	{
		return $this->insert($params);
	}

	/**
	 * Edit message of news
	 *
	 * @param int $id
	 * @param array $params Assoc array contains fields for update
	 *
	 * @return int Count of updated rows
	 */
	public function editConcert($id, array $params)
	{
		return $this->update( $params, array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}


	/**
	 * Delete concert
	 *
	 * @param int $id

	 * @return int Count of deleted rows
	 */
	public function delConcert($id)
	{
		return $this->delete( array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}


}
