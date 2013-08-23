<?php

class App_Model_Audio
{
	protected
			$_audioTable,
			$_albumTable;

	public function __construct()
	{
		$this->_audioTable = new App_Model_DbTable_Audio();
		$this->_albumTable = new App_Model_DbTable_Album();
	}

	/**
	 * Return last audio track
	 *
	 * @return Array|null
	 */
	public function getLastTrack()
	{
		$track = $this->_audioTable->getLastTrack();

		if( !is_null($track) ){
			$track['audio_link'] = $this->_prepareAudioLink($track['media_link']);
			$track['album'] = $this->_albumTable->getAlbumById($track['album_id']);
			$track['img_link'] = $this->_prepareAlbumImgLink($track['album_id']);
		}

		return $track;
	}

	protected function _prepareAudioLink($source_link)
	{
		$media_url = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('media_url');
		return sprintf("%s/%s", $media_url, $source_link);
	}

	protected function _generateAudioFilename($title)
	{
		return md5($title) . '_' . time();
	}

	protected function _prepareAlbumImgLink($album_id)
	{
		$media_url = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('media_url');
		return sprintf("%s/%s", $media_url, $this->_generateAlbumImgFilename($album_id));
	}

	protected function _generateAlbumImgFilename($album_id)
	{
		return sprintf('album_img_%d.png', $album_id);
	}
}
