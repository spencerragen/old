<?php

	@session_start();
	error_reporting(E_ALL);
	@set_magic_quotes_runtime(0);
	
	define('ROOT_DIR', dirname(__FILE__) . '/');
	define('TPL_DIR', ROOT_DIR . 'template/');
	
	require_once('general.php');
	require_once('SQLController.php');
	require_once('globals.conf');
	require_once(ROOT_DIR . 'smarty/Smarty.class.php');
	$DB = new SQLController('localhost', 'root', '', 'sb');
	$PAGE = new Smarty;
	$PAGE->caching = true;
	$PAGE->cache_lifetime = 120;

	#$DB->Query
	$_CSS[] = 'style.css';
	$_CSS[] = 'ui-darkness/jquery-ui-1.8.18.custom.css';
	$_JS[] = 'jquery-1.7.1.min.js';
	$_JS[] = 'jquery-ui-1.8.18.custom.min.js';
	#$_JS[] = 'js.js';
	$_JS[] = 'login.js';
	
	$page_title = 'TestSB';
	#$_template = 'login.tpl';

	$PAGE->assign('root_dir', "http://{$_SERVER['HTTP_HOST']}/sb");
	$PAGE->assign('tpl_dir', "http://{$_SERVER['HTTP_HOST']}/sb/templates/");
?>
