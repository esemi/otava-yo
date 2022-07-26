<?php

class App_Model_DbTable_Guestbook extends Zend_Db_Table_Abstract
{
	const NAME_LEVENSTEIN_DISTANCE_BORDER = 3;

	protected $_name = 'guestbook';

	public function getAllNotes()
	{
		$select = $this->select()
				->from($this, array(
					'id', 'author', 'user_date' => "DATE_FORMAT(date_publish, '%H:%i %d-%m-%y')",
					'email', 'city', 'site', 'content', 'iso_date' => "DATE_FORMAT(date_publish, '%Y-%m-%dT%H:%i')"))
				->where('parent_id IS NULL')
				->order("date_publish DESC");
		return $this->fetchAll($select);
	}

	public function getAllReplyes()
	{
		$select = $this->select()
				->from($this, array(
					'id', 'author', 'parent_id', 'user_date' => "DATE_FORMAT(date_publish, '%H:%i %d-%m-%y')",
					'email', 'city', 'site', 'content', 'iso_date' => "DATE_FORMAT(date_publish, '%Y-%m-%dT%H:%i')"))
				->where('parent_id IS NOT NULL')
				->order("date_publish ASC");
		return $this->fetchAll($select);
	}

	public function findById($id)
	{
		$select = $this->select()
						->from($this, array( 'id', 'author', 'email', 'city', 'site', 'content' ))
						->where('id = ?', $id, Zend_Db::INT_TYPE)
						->limit(1);
		return $this->fetchRow($select);
	}

	/**
	 * Prepare data for new post
	 *
	 * @param array $data post params (author*, email, city, site, message*)
	 * @param boolean $authFlag
	 * @return array Contains array of valid data and array of errors
	 */
	public function validate($data, $authFlag)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'email' => '',
			'site' => '',
			'city' => '',
			'author' => '',
			'content' => '',
			'parent_id' => null
		);

		if( empty($data['custom_captcha']) || $data['custom_captcha'] !== 'Ё' ){
			$errors[] = 'Для отправки сообщения необходимо включить JavaScript';
		}

		$moderAuthor = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('guestbook_reserved_name');
		if( empty($data['author']) || mb_strlen($data['author']) > 100 ){
			$errors[] = 'Некорректное имя автора';
		}elseif( $authFlag === false && levenshtein($data['author'], $moderAuthor) < self::NAME_LEVENSTEIN_DISTANCE_BORDER ){
			$errors[] = 'Данное имя зарезервированно за администрацией сайта';
		}else{
			$validData['author'] = $data['author'];
		}

		if( empty($data['content']) || mb_strlen($data['content']) > 10000 ){
			$errors[] = 'Некорректное сообщение';
		}else{
			$validData['content'] = $data['content'];
		}

		$validMail = new Zend_Validate_EmailAddress( array( 'mx' => true, 'deep' => true ) );
        if( empty($data['email']) || mb_strlen($data['email']) > 150 || !$validMail->isValid($data['email']) )
        {
            $errors[] = 'Некорректный адрес электронной почты';
        }else{
            $validData['email'] = $data['email'];
        }

		if( !empty($data['city']) )
		{
			if( mb_strlen($data['city']) > 255 )
			{
				$errors[] = 'Некорректный город/страна';
			}else{
				$validData['city'] = $data['city'];
			}
		}

		$validUrl = new Mylib_Validate_Url();
		if( !empty($data['site']) )
		{
			$url = 'http://' . str_replace(array('http://', 'https://'), '', $data['site']);
			if( mb_strlen($url) > 2055 || !$validUrl->isValid($url) ){
				$errors[] = 'Некорректный адрес домашней странички';
			}else{
				$validData['site'] = $url;
			}
		}

		if ($authFlag && !empty($data['parent_id'])) {
			if ($this->findById($data['parent_id'])) {
				$validData['parent_id'] = $data['parent_id'];
			}else{
				$errors[] = 'Некорректный идентификатор сообщения для ответа';
			}
		}

		// custom ban
		$bannedPhrases = ['cialis', 'viagra', 'smithe497@gmail.com'];
		foreach ($validData as $key => $value) {
			foreach ($bannedPhrases as $phrase) {
				if (strpos($value, $phrase) !== false) {
					$errors[] = 'Banned';
				}
			}
		}

		return array($validData, $errors);
	}

	/**
	 * Add new message to guestbook
	 *
	 * @param string $author
	 * @param string $content
	 * @param string $email
	 * @param string $site
	 * @param string $city
	 *
	 * @return int Inserted id
	 */
	public function addPost($author, $content, $email='', $site='', $city='', $parentId = null) {
		return $this->insert( array(
			'author' => $author,
			'parent_id' => $parentId,
			'content' => $content,
			'email' => $email,
			'city' => $city,
			'site' => $site,
			'date_publish' => new Zend_Db_Expr('NOW()') ));
	}

	/**
	 * Edit post from guestbook
	 *
	 * @param int $id
	 * @param string $author
	 * @param string $content
	 * @param string $email
	 * @param string $site
	 * @param string $city
	 *
	 * @return int Count of updated rows
	 */
	public function editPost($id, $author, $content, $email='', $site='', $city='')
	{
		return $this->update(
			array(
				'author' => $author,
				'content' => $content,
				'email' => $email,
				'city' => $city,
				'site' => $site ),
			array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) )
		);
	}

	/**
	 * Delete message from guestbook
	 *
	 * @param int $id

	 * @return int Count of deleted rows
	 */
	public function delPost($id)
	{
		return $this->delete( array( $this->_db->quoteInto( 'id = ?', $id, Zend_Db::INT_TYPE ) ) );
	}

}
