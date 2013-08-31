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
	 * Return all tracks
	 *
	 * @return Array
	 */
	public function getAllAudio()
	{
		$tracks = $this->_audioTable->getAll();
		foreach( $tracks as &$track ){
			$track['audio_link'] = $this->_prepareAudioLink($track['media_link']);
		}
		return $tracks;
	}

	/**
	 * Return all albums
	 *
	 * @return Array
	 */
	public function getAllAlbum()
	{
		$albums = $this->_albumTable->getAll();
		foreach( $albums as &$album ){
			$album['img_link'] = $this->_prepareAlbumImgLink($album['id']);
		}
		return $albums;
	}


	/**
	 * Return last audio track
	 *
	 * @return Array|null
	 */
	public function getRandTrack()
	{
		$track = $this->_audioTable->getRand();

		if( !is_null($track) ){
			$track['album'] = $this->_albumTable->getAlbumById($track['album_id']);
			$track['img_link'] = $this->_prepareAlbumImgLink($track['album_id']);
			$track['audio_link'] = $this->_prepareAudioLink($track['media_link']);
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
