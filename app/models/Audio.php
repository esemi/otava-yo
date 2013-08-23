<?php

class App_Model_Audio
{
	protected $_db;

	public function __construct()
	{
		$this->_db = new App_Model_DbTable_Audio();
	}

	public function getLastTrack()
	{
		$track = $this->_db->getLastTrack();
		if( !is_null($track) )
			$track->media_link = $this->_prepareAudioLink($track->media_link);

		return $track;
	}

	protected function _prepareAudioLink($source_link)
	{
		$media_url = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('media_url');
		return sprintf("%s/%s", $media_url, $source_link);
	}

	protected function _generateAudioHash($title)
	{
		return md5($title) . '_' . time();
	}
}
