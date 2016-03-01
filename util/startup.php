<?php

require_once('debug.settings.php');
require_once('general.functions.php');
require_once('session.functions.php');
require_once('database.functions.php');
require_once('site.setup.php');

//require_once('tasks.cron.php');

function __autoload($className) {
    $filename = $_SERVER['DOCUMENT_ROOT'].'/SmartClerk/scripts/'.$className .".class.php";
    include_once($filename);
}
