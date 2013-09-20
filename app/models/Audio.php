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
			$track['audio_link'] = $this->_prepareAudioLink($track['id']);
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
			$track['audio_link'] = $this->_prepareAudioLink($track['id']);
		}

		return $track;
	}

	protected function _prepareAudioLink($audio_id)
	{
		$media_url = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('media_url');
		return sprintf("%s/%s", $media_url, $this->_generateAudioFile($audio_id));
	}

	protected function _generateAudioFile($audio_id)
	{
		return sprintf('audio_track_%d.mp3', $audio_id);
	}

	protected function _prepareAlbumImgLink($album_id)
	{
		$media_url = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('media_url');
		return sprintf("%s/%s", $media_url, $this->_generateAlbumImgFilename($album_id));
	}

	protected function _generateAlbumImgFilename($album_id)
	{
		return sprintf('album_img_%d.jpg', $album_id);
	}

	public function albumValidate($data)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'title' => '',//required
			'year' => '',//required
			'desc' => '',
			'tracks' => array()
		);

		if( empty($data['title']) ){
			$errors[] = 'Укажите название';
		}elseif( mb_strlen($data['title']) > 255 ){
			$errors[] = 'Слишком длинное название';
		}else{
			$validData['title'] = $data['title'];
		}


		if( empty($data['year']) ){
			$errors[] = 'Укажите год';
		}elseif( !preg_match( '/^[\d]{4}$/', $data['year']) ){
			$errors[] = 'Некорректный год';
		}else{
			$validData['year'] = intval($data['year']);
		}

		if( !empty($data['desc']) ){
			$validData['desc'] = $data['desc'];
		}

		if( !empty($data['playlist']) ){
			$validData['tracks'] = $this->decodeAlbumPlaylist($data['playlist']);
		}

		return array($validData, $errors);
	}

	/**
	 * Decode playlist string to track names array
	 *
	 * @param string $playlist
	 * @return array Track names
	 */
	public function decodeAlbumPlaylist($playlist)
	{
		$tracks = explode("\n", $playlist);
		array_walk($tracks, 'trim');
		
		return $tracks;
	}
}
