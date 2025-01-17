<?php

define('APPLICATION_ENV', (getenv('APPLICATION_ENV')) ? getenv('APPLICATION_ENV') : 'production');

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));

define('WWW_PATH', realpath(dirname(__FILE__) . '/../www'));

define('ZEND_PATH', realpath(dirname(__FILE__) . '/../../Zend'));

define('LOG_PATH', realpath(dirname(__FILE__) . '/../logs'));

set_include_path(implode(PATH_SEPARATOR, array(
	ZEND_PATH,
	get_include_path()
)));

require_once 'Zend/Application.php';
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
			->run();