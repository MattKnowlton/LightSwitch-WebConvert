<?php

function array_sanitize($returnArr, $sanitizer = 'sanitize_sql_string') {
    array_walk_recursive($returnArr, function (&$value) use ($sanitizer) {
        $value = $sanitizer($value);
    });

    return $returnArr;
}

function isSSL() {
    if ((isset($_SERVER['HTTPS'])) && ($_SERVER['HTTPS'] == 1)) return TRUE; /* Apache */
    else if ((isset($_SERVER['HTTPS'])) && ($_SERVER['HTTPS'] == 'on')) return TRUE; /* IIS */
    else if ((isset($_SERVER['SERVER_PORT'])) && ($_SERVER['SERVER_PORT'] == 443)) return TRUE;
    else return FALSE;
}

function failed_because($failureReason, $returnValue = false){
    $backtrace = debug_backtrace(false);
    $function = (isset($backtrace[1])) ? '('.$backtrace[1]['function'].'::'.$backtrace[0]['line'].')' : '('.$backtrace[0]['file'].'::'.$backtrace[0]['line'].')';
    error_log($function.' : failed because : '.$failureReason);
    return $returnValue;
}

function filter_numeric_keys(array $dbExportArr) {
    foreach($dbExportArr as $key => $val) {
        if(is_array($val)) $dbExportArr[$key] = filter_numeric_keys($val);
        elseif(is_numeric($key)) unset($dbExportArr[$key]);
    }

    return array_sanitize(array_sanitize($dbExportArr, 'stripslashes'), 'stripslashes');
}

function generate_random_string($length = '7') {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_length = strlen($characters);
    $char_length--;
    $string = '';
    for($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, $char_length)];
    }

    return $string;
}

function email_link_decode($linkString) {
    if(strlen($linkString) == 0) return FALSE;

    $linkString = str_rot13($linkString);
    $linkString = base64_decode($linkString);
    if(stripos($linkString, '-') === FALSE) return FALSE;

    $linkData = explode('-', $linkString);

    return $linkData;
}

function email_link_encode($linkData) {
    if(empty($linkData) || count($linkData) == 0) return FALSE;

    $linkString = '';
    foreach($linkData as $linkItem) {
        if(strlen($linkString) > 0) $linkString .= '-';
        $linkString .= $linkItem;
    }
    if(strlen($linkString) == 0) return FALSE;

    $linkString = base64_encode($linkString);
    $linkString = str_replace('=', '', $linkString);
    $linkString = str_rot13($linkString);

    return $linkString;
}