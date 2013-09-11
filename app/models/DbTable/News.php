<?php

class App_Model_DbTable_News extends Zend_Db_Table_Abstract
{
	protected $_name = 'news';

	public function findById($id)
	{
		$select = $this->select()
						->from($this, array( 'id', 'title','content' ))
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

	public function getLast($limit)
	{
		$select = $this->select()
				->from($this, array('id','date_publish','title','content'))
				->order("date_publish DESC")
				->limit($limit);
		return $this->fetchAll($select);
	}

	public function getAll()
	{
		$select = $this->select()
				->from($this, array('id','date_publish','title','content'))
				->order("date_publish DESC");
		return $this->fetchAll($select);
	}

	public function stripContent($content, $limit)
	{
		$short = mb_substr(strip_tags($content), 0, $limit - 3);
		$pos = mb_strrpos($short, " ");
		if( $pos > 0 ){
			$short = mb_substr($short, 0, $pos);
		}
		return $short . '...';
	}

	public function validate($data)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'title' => '',
			'content' => '',
		);

		if( !empty($data['title']) ){
			if( mb_strlen($data['title']) > 255 ){
				$errors[] = 'Слишком длинный заголовок';
			}else{
				$validData['title'] = $data['title'];
			}
		}

		if( empty($data['content']) ){
			$errors[] = 'Пустое тело новости';
		}else{
			$validData['content'] = $data['content'];
		}

		return array($validData, $errors);
	}

	/**
	 * Add new message to news
	 *
	 * @param string $content
	 * @param string $title

	 * @return int Count of inserted rows
	 */
	public function addPost($content, $title='')
	{
		return $this->insert( array(
			'content' => $content,
			'title' => $title,
			'date_publish' => new Zend_Db_Expr('CURDATE()') ));
	}

	/**
	 * Edit message of news
	 *
	 * @param int $id
	 * @param string $content
	 * @param string $title

	 * @return int Count of updated rows
	 */
	public function editPost($id, $content, $title='')
	{
		return $this->update(
			array( 'content' => $content, 'title' => $title ),
			array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}


	/**
	 * Delete message from news
	 *
	 * @param int $id

	 * @return int Count of deleted rows
	 */
	public function delPost($id)
	{
		return $this->delete( array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}

}
