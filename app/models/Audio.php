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

	public function findAlbumById($id)
	{
		$album = $this->_albumTable->findById($id);
		if( !is_null($album) ){
			$album = $album->toArray();
			$album['img_link'] = $this->_prepareAlbumImgLink($album['id']);
			return $album;
		}else{
			return null;
		}
	}

	public function findTrackById($id)
	{
		$track = $this->_audioTable->findById($id);
		if( !is_null($track) ){
			return $track->toArray();
		}else{
			return null;
		}
	}


	public function getPlaylist($albumId)
	{
		return $this->_audioTable->findByAlbumId($albumId);
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

			$trackPath = WWW_PATH . $this->_prepareAudioLink($track['id']);
			$track['audio_link'] = ( file_exists($trackPath) && is_readable($trackPath) ) ? $this->_prepareAudioLink($track['id']) : null;
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
		$tracks = $this->getAllAudio();
		$tracks = array_filter($tracks, function($x){ return !is_null($x['audio_link']); });
		shuffle($tracks);

		$track = array_shift($tracks);
		$track['album'] = $this->_albumTable->findById($track['album_id']);
		$track['img_link'] = $this->_prepareAlbumImgLink($track['album_id']);

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

	public function albumValidate($data, $imgRequired = true)
	{
		array_walk($data, 'trim');

		$errors = array();
		$validData = array(
			'title' => '',	//required
			'year' => '',	//required
			'album_image' => null,	//required if create
			'desc' => '',
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

		//check img file
		$upload = new Zend_File_Transfer();
		$files = $upload->getFileInfo('album_image');
		if( empty($files['album_image']) || !$upload->isUploaded() ){
			if( $imgRequired === true ){
				$errors[] = 'Загрузите файл обложки альбома';
			}
		}else{
			$file = $files['album_image'];

			$exts = 'jpg,png,bmp,jpeg';
			$extensionValidate = new Zend_Validate_File_Extension($exts);
			if( ! $extensionValidate->isValid($file['tmp_name'], $file) ){
				$errors[] = "Недопустимое расширение файла ({$exts})";
			}

			$sizeValidate = new Zend_Validate_File_Size(2000000);
			if( ! $sizeValidate->isValid($file['tmp_name'], $file) ){
				$errors[] = "Файл слишком большой";
			}

			try{
				$img = new Imagick($file['tmp_name']);
				$res = $img->thumbnailImage(222, 200, true);
				if( $res === true ){
					$validData['album_image'] = $img;
				}
			}catch( ImagickException $e ){}

			if( !($validData['album_image'] instanceof Imagick) ){
				$errors[] = "Ошибка при преобразовании файла";
			}

			@unlink($file['tmp_name']);
		}

		return array($validData, $errors);
	}

	public function validateTrackTitle($title){
		$errors = array();
		$title = trim($title);

		if( empty($title) ){
			$errors[] = 'Название слишком короткое';
		}elseif( mb_strlen($title) > 255 ){
			$errors[] = 'Слишком длинное название';
		}

		return array($title, $errors);
	}

	public function addAlbum($title, $year, Imagick $image, $desc='')
	{
		$albumId = $this->_albumTable->addAlbum($title, $year, $desc);
		$this->_saveAlbumImg($albumId, $image);
	}

	public function addTrack($albumId, $title)
	{
		return $this->_audioTable->addTrack($albumId, $title);
	}

	public function editAlbum($id, $title, $year, $image, $desc='')
	{
		$res = $this->_albumTable->editAlbum($id, $title, $year, $desc);
		if( $image instanceof Imagick ){
			$this->_saveAlbumImg($id, $image);
		}
		return $res;
	}

	public function updTrackTitle($id, $title)
	{
		return $this->_audioTable->updTrackTitle($id, $title);
	}

	public function updTrackSortIndex($id, $index)
	{
		return $this->_audioTable->updTrackSortIndex($id, $index);
	}

	protected function _saveAlbumImg($albumId, Imagick $img){
		$albumImgPath = WWW_PATH . $this->_prepareAlbumImgLink($albumId);
		$img->writeimage($albumImgPath);
		chmod($albumImgPath , 0444);
	}

	public function delAlbum($id)
	{
		$tracks = $this->_audioTable->findByAlbumId($id);
		foreach( $tracks as $track ){
			$this->removeTrack($track['id']);
		}

		$res = $this->_albumTable->delAlbum($id);
		@unlink(WWW_PATH . $this->_prepareAlbumImgLink($id));

		return $res;
	}

	public function removeTrack($id){
		$this->_audioTable->delById($id);
		@unlink(WWW_PATH . $this->_prepareAudioLink($id));
	}

}
