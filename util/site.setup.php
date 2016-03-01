<?php

//define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);

const SITE_NAME = '';
const PATH = '';
//const PATH_LONG = 'http://localhost'. PATH;
const DOC_ROOT = '';

const DB_USER = "User";
const DB_NAME = 'Name';
const DB_HOST = 'localhost';
const DB_PASS = 'Pass';


//global $ajaxConn;
//$ajaxConn = new ajax;

define('INCLUDE_JS_JQUERY','<script src="'.PATH.'/scripts/jquery-2.2.0.js"></script>');
define('INCLUDE_JS_AJAX','<script src="'.PATH.'/scripts/ajax.class.js"></script>');
define('INCLUDE_JS_MAIN','<script src="'.PATH.'/scripts/main.functions.js"></script>');

define('INCLUDE_DEFAULT_JS',INCLUDE_JS_JQUERY."\r\n".INCLUDE_JS_AJAX."\r\n".INCLUDE_JS_MAIN);

define('INCLUDE_CSS_MAIN ','<link rel="stylesheet" type="text/css" href="'.PATH.'/scripts/main.css">');
define('INCLUDE_DEFAULT_CSS', '<link rel="stylesheet" type="text/css" href="'.PATH.'/scripts/main.css">');

