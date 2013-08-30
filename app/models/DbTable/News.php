<?php

class App_Model_DbTable_News extends Zend_Db_Table_Abstract
{
	protected $_name = 'news';

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
		$short = mb_substr($content, 0, $limit - 3);
		$pos = mb_strrpos($short, ' ');
		if( $pos > 0 ){
			$short = mb_substr($short, 0, $pos);
		}
		return $short . '...';
	}
}
