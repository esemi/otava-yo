<?php

class App_Model_DbTable_Guestbook extends Zend_Db_Table_Abstract
{
	protected $_name = 'guestbook';

	public function getAll()
	{
		$select = $this->select()
				->from($this, array(
					'id', 'author', 'user_date' => "DATE_FORMAT(date_publish, '%H:%i %d-%m-%y')",
					'email', 'city', 'site', 'content', 'iso_date' => "DATE_FORMAT(date_publish, '%Y-%m-%dT%H:%i')"))
				->order("date_publish DESC");
		return $this->fetchAll($select);
	}

	/**
	 * Prepare data for new post
	 *
	 * @param array $data post params (author*, email, city, site, message*)
	 * @return array Contains array of valid data and array of errors
	 */
	public function prepareNewPost($data)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'email' => '',
			'site' => '',
			'city' => '',
		);

		$moderAuthor = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('guestbook_reserved_name');
		if( empty($data['author']) || mb_strlen($data['author']) > 100 ){
			$errors[] = 'Некорректное имя автора';
		}elseif( levenshtein($data['author'], $moderAuthor) < 3 ){
			$errors[] = 'Данное имя зарезервированно';
		}else{
			$validData['author'] = $data['author'];
		}

		if( empty($data['message']) || mb_strlen($data['message']) > 10000 ){
			$errors[] = 'Некорректное сообщение';
		}else{
			$validData['message'] = $data['message'];
		}

		$validMail = new Zend_Validate_EmailAddress( array( 'mx' => true, 'deep' => true ) );
		if( !empty($data['email']) )
		{
			if( mb_strlen($data['city']) > 150 || !$validMail->isValid($data['email']) )
			{
				$errors[] = 'Некорректный адрес электронной почты';
			}else{
				$validData['email'] = $data['email'];
			}
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
			if( mb_strlen($url) > 255 || !$validUrl->isValid($url) )
			{
				$errors[] = 'Некорректный адрес домашней странички';
			}else{
				$validData['site'] = $url;
			}
		}

		return array($validData, $errors);
	}

	/**
	 * Add new message to guestbook
	 *
	 * @param string $author
	 * @param string $message
	 * @param string $email
	 * @param string $site
	 * @param string $city
	 *
	 * @return int Count of inserted rows
	 */
	public function addPost($author, $message, $email='', $site='', $city='')
	{
		return $this->insert( array(
			'author' => $author,
			'content' => $message,
			'email' => $email,
			'city' => $city,
			'site' => $site,
			'date_publish' => new Zend_Db_Expr('NOW()') ));
	}

}
