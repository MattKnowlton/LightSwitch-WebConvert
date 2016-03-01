<?php

/**
 * \mainpage Rapid PHP Library
 *
 * version 0.005 Creation of rsearch 9-13-2010
 *
 * Copyright 2010 International Academy of Science
 *
 * @version 0.005
 */

/**
 * @param        $level
 * @param        $file
 * @param        $function
 * @param        $line
 * @param string $msg
 */
function debug($level, $file, $function, $line, $msg = '')
{
    global $log;
    global $log_file;
    global $log_teacher;
    global $log_student;
    global $log_all;
    $debug = false;
    if ($log == '1') {
        /*switch ($level) {
            case "ERROR":
                $string = "[ERROR]  ";
                break;
            case "WARNING":
                $string = "[WARNING]";
                break;
            case "INFORMA":
                $string = "[INFORMA]";
                break;
            case "VERBOSE":
            default:
                $string = "[VERBOSE]";
                break;
        }*/
        $string = date("Ymd G:i:s ");
        $sess = substr(session_id(), -4);
        $tfile = substr($file, -10);
        $string .= "[" . $sess . "]-" . $tfile . " " . $function . " (" . $line . ")";
        if ($msg != "") {
            $msg = str_replace("\"", "", $msg);
            $msg = str_replace('"', '', $msg);
            $msg = str_replace('\'', '', $msg);
            $msg = str_replace('$', '', $msg);
            $string .= " - " . $msg;
        }
        if ($log_all) {
            $debug = true;
        } else {
            if (safe_session('isTeacher') == 'TRUE') {
                if ($log_teacher) {
                    $debug = true;
                }
            } else {
                if ($log_student) {
                    $debug = true;
                }
            }
        }
        if ($debug) {
            error_log($string . "\n", 3, $log_file);
            //system("echo \"" . $string . "\" >> " . $log_file);
        }
    }
}

function _S($in)
{
    return sanitize_sql_string($in);
}

function _P($in)
{
    if (isset($_REQUEST[$in]))
        return $_REQUEST[$in];
    return '';
}

function session_set($in)
{
    if (!isset($_SESSION[$in])) $_SESSION[$in] = '';
}

function safe_session($in)
{
    if (isset($_SESSION[$in])) return $_SESSION[$in];
    return '';
}

// sanitize a string for HTML (make sure nothing gets interpretted!)
function sanitize_html_string($string, $min = '', $max = '')
{
    $len = strlen($string);
    if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
        return FALSE;
//        $pattern[0] = '/\&/';
    $pattern[1] = '/</';
    $pattern[2] = "/>/";
    $pattern[3] = '/\n/';
    $pattern[4] = '/"/';
    $pattern[5] = "/'/";
    $pattern[6] = "/%/";
    //   $pattern[7] = '/\(/';
    //   $pattern[8] = '/\)/';
    //    $pattern[9] = '/\+/';
    //   $pattern[10] = '/-/';
    //      $replacement[0] = '&amp;';
    $replacement[1] = '&lt;';
    $replacement[2] = '&gt;';
    $replacement[3] = '<br>';
    $replacement[4] = '&quot;';
    $replacement[5] = '&#39;';
    $replacement[6] = '&#37;';
    //  $replacement[7] = '&#40;';
    //  $replacement[8] = '&#41;';
    //   $replacement[9] = '&#43;';
    //   $replacement[10] = '&#45;';
    return preg_replace($pattern, $replacement, $string);
}

// sanitize a string for SQL input (simple slash out quotes and slashes)
function sanitize_sql_string($string, $min = '', $max = '')
{
    $pattern[0] = '/(\\\\)/';
    $pattern[1] = "/\"/";
    $pattern[2] = "/'/";
    $replacement[0] = '\\\\\\';
    $replacement[1] = '\"';
    $replacement[2] = "\\'";
    $len = strlen($string);
    if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
        return FALSE;
    return preg_replace($pattern, $replacement, $string);
}
function _R($in)
{
    if (isset($_REQUEST[$in]))
        return sanitize_sql_string($_REQUEST[$in]);
    return '';
}
function _H($in){
    return sanitize_html_string($in);
}

/**
 * @param rdb    $db
 * @param        $query
 * @param string $label
 * @return void
 */
function RunQuery(Rdb &$db, $query, $label = '0')
{
    $db->execute($query, $label);
}

function encode($string, $key)
{
    $key = sha1($key);
    $hash = '';
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0, $j = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function decode($string, $key)
{
    $key = sha1($key);
    $hash = '';
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0, $j = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function indexDBResult($dbResult, $index){
    foreach($dbResult as $record){
        if(!isset($record[$index])) continue;
        $indexedResult[$record[$index]] = $record;
    }
    return $indexedResult;
}

function export_Assoc(array $dbExportArr) {
    foreach($dbExportArr as $key => $val) {
        if(is_array($val)) $dbExportArr[$key] = export_Assoc($val);
        elseif(is_numeric($key)) unset($dbExportArr[$key]);
    }

    return arrayFilter($dbExportArr, 'stripslashes');
}

function arrayFilter($returnArr, $filter = 'sanitize_sql_string') {
    array_walk_recursive($returnArr, function (&$value) use ($filter) {
        $value = $filter($value);
    });

    return $returnArr;
}



class _createTableString
{

    private $query;
    private $database;
    private $table;
    private $queryString;

    function __construct()
    {
    }

    public function get()
    {
        $this->queryString = implode(',', $this->query);
        return $this->queryString;
    }

    public function assembleStructure()
    {
        $this->queryString = implode(',', $this->query);
        return $this->queryString;
    }

    private function sanitize(&$recordName)
    {
        return;
    }

    public function setDatabase($databaseName)
    {
        $this->database = $databaseName;
        return $this;
    }

    public function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    public function createDatabase()
    {
        if ($this->database == '') {
            return false;
        }
        $this->query = "CREATE DATABASE IF NOT EXISTS " . $this->database;
        return $this->query;
    }

    public function createTable()
    {
        if ($this->database == '') {
            return false;
        }
        if ($this->table == '') {
            return false;
        }
        $structure = $this->assembleStructure();
        $this->query = "CREATE TABLE IF NOT EXISTS " . $this->database . "." . $this->table . " (" . $structure . ")";
        return $this->query;
    }

    public function _index($name, $fields = "", $unique = false) {
        sanitize($name, SQL);
        if ($fields == '') $fields = $name;
        else sanitize($fields, SQL);
        $this->query[] = sprintf("%s key `%s` (%s)", ($unique) ? "unique" : "", $name, $fields);
        return $this;
    }

    public function _key($recordName)
    {
        unset($this->query);
        $this->query = array();
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' INT AUTO_INCREMENT PRIMARY KEY';
        return $this;
    }

    public function _keychar($recordName, $length)
    {
        unset($this->query);
        $this->query = array();
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' CHAR(' . intval($length) . ') AUTO_INCREMENT PRIMARY KEY';
        return $this;
    }

    public function _int($recordName, $size = 11, $Default = '')
    {
        if ($Default != '') {
            $Default = ' DEFAULT ' . $Default . ' ';
        }
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' INT(' . $size . ') NOT NULL' . $Default;
        return $this;
    }

    public function _double($recordName)
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' DOUBLE NOT NULL';
        return $this;
    }

    public function _date($recordName)
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' DATE NOT NULL';
        return $this;
    }

    public function _bigint($recordName)
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' BIGINT NOT NULL';
        return $this;
    }

    public function _char($recordName, $length = 10)
    {
        sanitize($recordName, SQL);
        if ($length <= 8) {
            $this->query[] = $recordName . ' CHAR(' . intval($length) . ') NOT NULL';
        } else {
            $this->query[] = $recordName . ' VARCHAR(' . intval($length) . ') NOT NULL';
        }
        return $this;
    }

    public function _decimal($recordName, $high, $low, $default = '0')
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' DECIMAL(' . $high . ',' . $low . ') NOT NULL DEFAULT ' . "'$default'";
        return $this;
    }

    public function _time($recordName, $default = '00:00:00')
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . " TIME NOT NULL DEFAULT '$default'";
        return $this;
    }

    public function _text($recordName)
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' TEXT NOT NULL';
        return $this;
    }

    public function _blob($recordName)
    {
        sanitize($recordName, SQL);
        $this->query[] = $recordName . ' BLOB NOT NULL';
        return $this;
    }

}


define("PARANOID", 1);
define("SQL", 2);
define("SYSTEM", 4);
define("HTML", 8);
define("INT", 16);
define("FLOAT", 32);
define("LDAP", 64);
define("UTF8", 128);

// internal function for utf8 decoding
function my_utf8_decode($string)
{
    return strtr($string, "???????¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
}

// paranoid sanitization -- only let the alphanumeric set through
function sanitize_paranoid_string($string, $min = '', $max = '')
{
    $string = preg_replace("/[^a-zA-Z0-9]/", "", $string);
    $len = strlen($string);
    return $string;
}

// sanitize a string in prep for passing a single argument to system() (or similar)
function sanitize_system_string($string, $min = '', $max = '')
{
    /*$pattern = '/(;|\||`|>|<|&|^|"|' . "\n|\r|'" . '|{|}|[|]|\)|\()/i'; // no piping, passing possible environment variables ($),
    // seperate commands, nested execution, file redirection,
    // background processing, special commands (backspace, etc.), quotes
    // newlines, or some other special characters
    $string = preg_replace($pattern, '', $string);
    $string = '"' . preg_replace('/\$/', '\\\$', $string) . '"'; //make sure this is only interpretted as ONE argument
    $len = strlen($string);
    return $string;*/
    $pattern[0] = '/(\\\\)/';
    $pattern[1] = "/\"/";
    $pattern[2] = "/'/";
    $pattern[3] = "/`/";
    $replacement[0] = '\\\\\\';
    $replacement[1] = '\"';
    $replacement[2] = "'";
    $replacement[3] = "\`";
    $len = strlen($string);
    if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
        return FALSE;
    return preg_replace($pattern, $replacement, $string);
}

// sanitize a string for SQL input (simple slash out quotes and slashes)
function sanitize_ldap_string($string, $min = '', $max = '')
{
    $pattern = '/(\)|\(|\||&)/';
    $len = strlen($string);
    return preg_replace($pattern, '', $string);
}
/*
// sanitize a string for HTML (make sure nothing gets interpretted!)
// glue together all the other functions
function sanitize($input, $flags, $min = '', $max = '')
{
    if ($flags & UTF8)
        $input = my_utf8_decode($input);
    if ($flags & PARANOID)
        $input = sanitize_paranoid_string($input, $min, $max);
    if ($flags & INT)
        $input = intval($input);
    if ($flags & FLOAT)
        $input = floatval($input);
    if ($flags & HTML) {
        $input = htmlentities($input);
        $input = str_replace("<br>","\\n",$input);
    }
    if ($flags & SQL)
        $input = sanitize_sql_string($input, $min, $max);
    if ($flags & LDAP)
        $input = sanitize_ldap_string($input, $min, $max);
    if ($flags & SYSTEM)
        $input = sanitize_system_string($input, $min, $max);
    if ((($min != '') && ($input < $min)) || (($max != '') && ($input > $max)))
        return FALSE;
    return $input;
}*/
function sanitize($input, $flags, $min='', $max='')
{
    $min = 0; $max=100000;
    if($flags & PARANOID) $input = sanitize_paranoid_string($input, $min, $max);
    if($flags & INT) $input = sanitize_int($input, $min, $max);
    if($flags & FLOAT) $input = sanitize_float($input, $min, $max);
    if($flags & HTML) $input = sanitize_html_string($input, $min, $max);
    if($flags & SQL) $input = sanitize_sql_string($input, $min, $max);
    if($flags & LDAP) $input = sanitize_ldap_string($input, $min, $max);
    if($flags & SYSTEM) $input = sanitize_system_string($input, $min, $max);
    return $input;
}

class rdb
{
    private $host;
    private $user_name;
    private $password;
    private $db_name;
    private $link_id;
    private $result;
    private $col;
    private $query;
    private $StartTime;
    var $fields;
    var $records;
    private $ar_query_type;
    private $ar_select = array();
    private $ar_table;
    private $ar_where;
    private $ar_join;
    private $ar_order;
    private $ar_update;
    private $error_msg;
    private $last_query;
    private $ar_limit;
    private $log_table_array = array();
    private $longest_query_ran;
    private $longest_query;
    private $query_count;
    private $Debug;
    private $setting;

    // paranoid sanitization -- only let the alphanumeric set through
    private function sanitize_paranoid_string($string, $min = '', $max = '')
    {
        $string = preg_replace("/[^a-zA-Z0-9]/", "", $string);
        $len = strlen($string);
        if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
            return FALSE;
        return $string;
    }

    // sanitize a string in prep for passing a single argument to system() (or similar)
    private function sanitize_system_string($string, $min = '', $max = '')
    {
        $pattern = '/(;|\||`|>|<|&|^|"|' . "\n|\r|'" . '|{|}|[|]|\)|\()/i'; // no piping, passing possible environment variables ($),
        // seperate commands, nested execution, file redirection,
        // background processing, special commands (backspace, etc.), quotes
        // newlines, or some other special characters
        $string = preg_replace($pattern, '', $string);
        $string = '"' . preg_replace('/\$/', '\\\$', $string) . '"'; //make sure this is only interpretted as ONE argument
        $len = strlen($string);
        if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
            return FALSE;
        return $string;
    }

    // sanitize a string for SQL input (simple slash out quotes and slashes)
    private function sanitize_sql_string($string, $min = '', $max = '')
    {
        $pattern[0] = '/(\\\\)/';
        $pattern[1] = "/\"/";
        $pattern[2] = "/'/";
        $replacement[0] = '\\\\\\';
        $replacement[1] = '\"';
        $replacement[2] = "\\'";
        $len = strlen($string);
        if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
            return FALSE;
        return preg_replace($pattern, $replacement, $string);
    }

    // sanitize a string for SQL input (simple slash out quotes and slashes)
    private function sanitize_ldap_string($string, $min = '', $max = '')
    {
        $pattern = '/(\)|\(|\||&)/';
        $len = strlen($string);
        if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
            return FALSE;
        return preg_replace($pattern, '', $string);
    }

    // sanitize a string for HTML (make sure nothing gets interpretted!)
    private function sanitize_html_string($string, $min = '', $max = '')
    {
        $len = strlen($string);
        if ((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
            return FALSE;
//        $pattern[0] = '/\&/';
        $pattern[1] = '/</';
        $pattern[2] = "/>/";
        $pattern[3] = '/\n/';
        $pattern[4] = '/"/';
        $pattern[5] = "/'/";
        $pattern[6] = "/%/";
        $pattern[7] = '/\(/';
        $pattern[8] = '/\)/';
        //    $pattern[9] = '/\+/';
        //  $pattern[10] = '/-/';
        //      $replacement[0] = '&amp;';
        $replacement[1] = '&lt;';
        $replacement[2] = '&gt;';
        $replacement[3] = '<br>';
        $replacement[4] = '&quot;';
        $replacement[5] = '&#39;';
        $replacement[6] = '&#37;';
        $replacement[7] = '&#40;';
        $replacement[8] = '&#41;';
        //  $replacement[9] = '&#43;';
        //  $replacement[10] = '&#45;';
        return preg_replace($pattern, $replacement, $string);
    }

    // make int int!
    private function sanitize_int($integer, $min = '', $max = '')
    {
        $int = intval($integer);
        if ((($min != '') && ($int < $min)) || (($max != '') && ($int > $max)))
            return FALSE;
        return $int;
    }

    // make float float!
    private function sanitize_float($float, $min = '', $max = '')
    {
        $float = floatval($float);
        if ((($min != '') && ($float < $min)) || (($max != '') && ($float > $max)))
            return FALSE;
        return $float;
    }

    // glue together all the other functions

    /**
     *Outputs sanitized version of input variables
     *
     * @param $input        Variable with contaminated data.
     * @param $flags        Flag specifying which santitaion to use.
     * \li \c PARANOID removes all non-alpha-numeric characters from the input string.
     * \li \c INT   returns FALSE if not an integer.
     * \li \c FLOAT returns FALSE if not an floating point number.
     * \li \c HTML  exchanges all XML characters with sane HTML representation.
     * \li \c SQL   sanitizes for a MySQL string.
     * @param $min          Optional. Can specify a minimum text length, or a mimumum number value.
     * @param $max          Optional. Can specify a maximum text length, or a maximum number value.
     * @return              Sanitized output, or FALSE if data outside \p min or \p max.
     * @since 0.004
     */
    function sanitize($input, $flags, $min = '', $max = '')
    {
        if ($flags & PARANOID) $input = $this->sanitize_paranoid_string($input, $min, $max);
        if ($flags & INT) $input = $this->sanitize_int($input, $min, $max);
        if ($flags & FLOAT) $input = $this->sanitize_float($input, $min, $max);
        if ($flags & HTML) $input = $this->sanitize_html_string($input, $min, $max);
        if ($flags & SQL) $input = $this->sanitize_sql_string($input, $min, $max);
        if ($flags & LDAP) $input = $this->sanitize_ldap_string($input, $min, $max);
        if ($flags & SYSTEM) $input = $this->sanitize_system_string($input, $min, $max);
        return $input;
    }

    /**
     *Sanitization just for SQL
     *
     * @param $input        Variable with contaminated data.
     * @return              Sanitized output.
     * @see sanitize
     * @since 0.004
     */
    function sanitize_sql($input)
    {
        $input = $this->sanitize_sql_string($input);
        return $input;
    }
    /**
     * Initializes the rdb class.
     * \warning Do not call explicitly.
     *
     * @see   __construct
     * @since 0.002
     * @param $_host
     * @param $_user
     * @param $_password
     * @param $_db_name
     */
    function init($_host, $_user, $_password, $_db_name)
    {
        $this->longest_query_ran = 0.0;
        $this->longest_query = '';
        $this->host = $_host;
        $this->user_name = $_user;
        $this->password = strrev($_password);
        $this->db_name = $_db_name;
        $this->fields = array();
        $this->records = array();
        $this->error_msg = '';
        $this->link_id = @mysql_connect($_host, $_user, $this->password);
        if (!$this->link_id) {
            $this->error_msg = "Unable to connect to the server. " . mysql_error($this->link_id);
            // or die("Your website is not properly installed.");
        }
        @mysql_select_db($_db_name, $this->link_id);
    }

    private function query($_query)
    {
        $start = microtime(true);
        $this->query = $_query;
        $this->result = @mysql_query($_query, $this->link_id) or error_log("Query: " . $_query . " Error: (" . mysql_errno() . ") " . mysql_error());
        $end = microtime(true);
        $query_time = $end - $start;
        if ($this->result === false) $this->error_msg = mysql_error($this->link_id);
        if ($query_time > $this->longest_query_ran) {
            $this->longest_query_ran = $query_time;
            $this->longest_query = $_query;
        }
        if (mysql_error($this->link_id) == 0) {
            return $this->result;
        } else {
            syslog(LOG_ERR, mysql_error($this->link_id) . '<br> SQL:' . $_query);
        }
        //or die(mysql_error($this->link_id) . '<br> SQL:' . $_query);
        //;// or print($_query . "<p>" . mysql_error($this->link_id));
        return $this->result;
    }

    private function get_records($result_key)
    {
        $this->records[$result_key] = array();
        $this->fields[$result_key] = array();
        //$num_rows = @mysql_num_rows($this->result);
        while ($row = @mysql_fetch_array($this->result, MYSQL_BOTH)) {
            $this->records[$result_key][count($this->records[$result_key])] = $row;
            $mod_check = 0;
            FOREACH ($row AS $ENTRY => $VALUE) {
                $mod_check++;
                if ($mod_check % 2 == 0) {
                    $this->fields[$result_key][count($this->fields[$result_key])] = $ENTRY;
                    $this->fields[$result_key] = array_unique($this->fields[$result_key]);
                }
            }
            //    unset($row);
        }
        //mysql_free_result($this->result);
        //unset($this->result);
        reset($this->records);
        reset($this->fields);
        return $this->records;
    }

    private function p_num_rows($result_key)
    {
        return count($this->records[$result_key]);
    }

    private function p_error_msg()
    {
        return $this->error_msg; //mysql_error($this->link_id);
    }

    private function done()
    {
        @mysql_close($this->link_id);
    }

    public function check_label($result_key)
    {
        if (isset($this->records[$result_key]))
            return true;
        return false;
    }

    /**
     * Initializes the rdb class.
     *
     * Call "$variable = new rdb($host, $user, $password, $database);" to initialize.
     *
     * @param $host         string The MySQL host. Usually "localhost".
     * @param $user         string MySQL Username.
     * @param $password     string MySQL Password.
     * @param $db_name      string MySQL Database to initially connect to.
     * @return              MySQL connect result.
     * @since 0.001
     */

    /**
     * @param      $host
     * @param      $user
     * @param      $password
     * @param      $db_name
     * @param bool $Debug_ON
     */
    function __construct($host, $user, $password, $db_name, $Debug_ON = false)
    {
        $this->StartTime = microtime(true);
        $this->log_table_array = array();
        $this->Debug = $Debug_ON;
        $this->query_count = 0;
        //$this->result = resource;
        return $this->init($host, $user, $password, $db_name);
    }

    private $log_id;

    public function log_id($ID)
    {
        $this->log_id = $ID;
    }

    function __destruct()
    {
        global $log_all_queries;
        if ($log_all_queries) {
            $message = 'Spent (' . round(floatval(microtime(true) - $this->StartTime), 4) . ') seconds, (' . $this->query_count . ') queries on ' . $_SERVER['PHP_SELF'] . '.';
            if ($this->log_id != '') {
                $message .= ' [' . $this->log_id . ']';
            }
            foreach ($this->log_table_array AS $key => $value) {
                $message .= "\n[$key] -> ";
                foreach ($value AS $minorKey => $minorValue) {
                    $message .= $minorKey . '(' . intval($minorValue) . ')';
                }
            }
            if ($this->longest_query_ran > 0.0) {
                $message .= "\nLongest Query Time: [$this->longest_query_ran] - [$this->longest_query]";
            }
            debug(1, __FILE__, __FUNCTION__, __LINE__, $message);
        }
        $this->done();
    }

    /**
     * Executes a MySQL query
     *
     * @param $query        string A query in MySQL syntax.
     * @param $result_key   Optional for running multiple queries.
     * @return              Mysql error result.
     * @since 0.001
     */
    function execute($query, $result_key = "0")
    {
        if ($query == '')
            return false;
        global $log_all_queries;
        if ($log_all_queries) {
            debug("VERBOSE", __FILE__, __FUNCTION__, __LINE__, $query);
        }
        $this->query_count++;
        $this->last_query = $query;
        $this->query($query);
        $this->get_records($result_key);
        return $this->result;
    }

    public function debug_last()
    {
        //put debug_backtrace in here
        //error_log('SQL:' . $this->last_query());
        debug("INFORMA", __FILE__, __FUNCTION__, __LINE__, $this->last_query());
    }

    public function last_query()
    {
        return $this->last_query;
    }

    /**
     * @param        $field_name
     * @param int    $index_number
     * @param string $result_key
     * @return bool|mixed|string
     */
    function result($field_name, $index_number = 0, $result_key = "0")
    {
        if (
            isset($this->records[$result_key]) &&
            isset($this->records[$result_key][$index_number]) &&
            isset($this->records[$result_key][$index_number][$field_name])
        )
            return $this->records[$result_key][$index_number][$field_name];
        // return sanitize($this->records[$result_key][$index_number][$field_name], HTML);
        else
            return '';
    }

    function result_u($field_name, $index_number = 0, $result_key = "0")
    {
        if (
            isset($this->records[$result_key]) &&
            isset($this->records[$result_key][$index_number]) &&
            isset($this->records[$result_key][$index_number][$field_name])
        )
            return $this->records[$result_key][$index_number][$field_name];
        else
            return '';
    }

    /**
     * @param string $result_key
     * @return array
     */
    function export_result($result_key = "0", $associative_array = true)
    {
        if (isset($this->records[$result_key])){
            if(!$associative_array) return $this->records[$result_key];
            return export_Assoc($this->records[$result_key]);
        }
        return array();
    }


    /**
     * @param string $result_key
     * @return int
     */
    function num_rows($result_key = "0")
    {
        return $this->p_num_rows($result_key);
    }

    /**
     * Returns the latest MySQL error.
     *
     * @return              Mysql error message string.
     * @since 0.001
     */
    function error_msg()
    {
        return $this->p_error_msg();
    }

    /**
     * Changes the current database.
     *
     * @param $_db_name     Database name
     * @return              Mysql change result code.
     * @since 0.003
     */
    function select_db($_db_name)
    {
        $this->db_name = $_db_name;
        return @mysql_select_db($_db_name, $this->link_id);
    }

    /**
     * Prints the current MySQL Results Array
     *
     * @since 0.002
     */
    function print_results()
    {
        print_r($this->records);
    }

//$this->db->select('title')->from('myTable')->where('id', $id)->limit(10, 20);
    //$this->db->get();

    public function order_by($order)
    {

        if (is_string($order)) {
            $order = explode(',', $order);
        }
        foreach ($order as $val) {
            $val = trim($val);
            if ($val != '') {
                $this->ar_order[] = $val;
            }
        }
        return $this;
    }

    public function select($select = '*')
    {
        $this->ar_clean();
        $this->ar_query_type = 'select';
        if (is_string($select)) {
            $select = explode(',', $select);
        }
        foreach ($select as $val) {
            //$val = trim($val);
            if ($val != '') {
                $this->ar_select[] = $val;
            }
        }
        return $this;
    }

    public function select_cache($select = '*')
    {
        $this->ar_clean();
        $this->ar_query_type = 'select_cache';
        if (is_string($select)) {
            $select = explode(',', $select);
        }
        foreach ($select as $val) {
            $val = trim($val);
            if ($val != '') {
                $this->ar_select[] = $val;
            }
        }
        return $this;
    }

    public function set($set, $value = '')
    {
        if (is_string($set)) {
            $set = explode(',', $set);
        }
        if (!is_array($set)) {
            $set = array($set => $value);
        }
        foreach ($set as $k => $v) {
            if (!is_null($v)) {
                $v = $this->escape($v);
                if ($this->_has_operator($v) && (is_null($k) || is_numeric(substr($k, 0, 1)))) {
                    $this->ar_update[] = $v;
                    continue;
                } elseif (!$this->_has_operator($k)) {
                    $k .= '=';
                }
                $v = mysql_real_escape_string($v, $this->link_id);
            } else {
                $k .= '=';
            }
            if (substr($v, 0, 2) == "0x" && preg_match("/[^0-9a-f]/i", substr($v, 2)) == 0)
                $this->ar_update[] = $k . $v;
            else $this->ar_update[] = $k . '\'' . $v . '\'';
        }
        return $this;
    }

    public function set_without_space($set, $value = '')
    {
        if (is_string($set)) {
            $set = explode(',', $set);
        }
        if (!is_array($set)) {
            $set = array($set => $value);
        }
        foreach ($set as $k => $v) {
            if (!is_null($v)) {
                $v = $this->escape($v);
                if ($this->_has_operator_without_space($v)) {
                    $this->ar_update[] = $v;
                    continue;
                } elseif (!$this->_has_operator_without_space($k)) {
                    $k .= '=';
                }
            } else {
                $k .= '=';
            }
            if (substr($v, 0, 2) == "0x" && preg_match("/[^0-9a-f]/i", substr($v, 2)) == 0)
                $this->ar_update[] = $k . $v;
            else $this->ar_update[] = $k . '\'' . $v . '\'';
        }
        return $this;
    }

    public function set_straight($set, $value = '')
    {
        if (is_string($set)) {
            $set = explode(',', $set);
        }
        if (!is_array($set)) {
            $set = array($set => $value);
        }
        foreach ($set as $k => $v) {
            if (!is_null($v)) {
                $v = $this->escape($v);
            }
            if (!$this->_has_operator($k)) {
                $k .= '=';
            }
            if (substr($v, 0, 2) == "0x" && preg_match("/[^0-9a-f]/i", substr($v, 2)) == 0)
                $this->ar_update[] = $k . $v;
            else $this->ar_update[] = $k . '\'' . $v . '\'';
        }
        return $this;
    }

    public function update($table)
    {
        //$db->update('table')->set(array('this'=>$that))->where(array('that'=>$this);
        $this->ar_clean();
        $this->ar_query_type = 'update';
        $this->ar_table = $table;
        return $this;
    }

    public function delete($table)
    {
        //$db->update('table')->set(array('this'=>$that))->where(array('that'=>$this);
        $this->ar_clean();
        $this->ar_query_type = 'delete';
        $this->ar_table = $table;
        return $this;
    }

    public function insert($table)
    {
        //$db->update('table')->set(array('this'=>$that))->where(array('that'=>$this);
        $this->ar_clean();
        $this->ar_query_type = 'insert';
        $this->ar_table = $table;
        return $this;
    }

    public function limit($limit)
    {
        $this->ar_limit = $limit;
        return $this;
    }

    public function from($table)
    {
        $this->ar_table = $table;
        return $this;
    }

    public function where($key, $value = NULL, $escape = TRUE)
    {
        $this->_where($key, $value, 'AND ', $escape);
        return $this;
    }

    public function join($table = '', $on = '', $joinType = '')
    {
        if (empty($table) || empty($on)) return $this;
        $table = $this->escape($table);
        $on = $this->escape($on);
        // SELECT * FROM blogs
        // JOIN comments ON comments.id = blogs.id
        $joinType = strcasecmp($joinType, 'LEFT') == 0 ? ' LEFT' : strcasecmp($joinType, 'RIGHT') == 0 ? ' RIGHT' : '';
        $this->ar_join = $joinType . ' JOIN ' . $table . ' ON ' . $on;
        return $this;
    }

    public function get($label = '0')
    {
        $query = '';
        if ($this->ar_query_type == 'select') {
            $query = $this->_format_select();
        }
        if ($this->ar_query_type == 'select_cache') {
            $query = $this->_format_select(true);
        }
        if ($this->ar_query_type == 'update') {
            $query = $this->_format_update();
        }
        if ($this->ar_query_type == 'insert') {
            $query = $this->_format_insert();
        }
        if ($this->ar_query_type == 'delete') {
            $query = $this->_format_delete();
        }
        $this->execute($query, $label);
        $this->log_table();
        return $this->result;
    }

    public function get_e($label = '0')
    {
        if ($this->get($label) === false) {
            throw new Exception($this->error_msg);
        }
    }



    public function or_where($key, $value = NULL, $escape = TRUE)
    {
        return $this->_where($key, $value, 'OR ', $escape);
    }

    public function escape($value)
    {
        //return mysql_real_escape_string($value);
        $pattern[0] = '/(\\\\)/';
        $pattern[1] = "/\\\"/";
        $pattern[2] = "/\\'/";
        $replacement[0] = '\\';
        $replacement[1] = '"';
        $replacement[2] = "'";
        preg_replace($pattern, $replacement, $value);
        $pattern[0] = '/(\\\\)/';
        $pattern[1] = "/\"/";
        $pattern[2] = "/'/";
        $replacement[0] = '\\\\\\';
        $replacement[1] = '\"';
        $replacement[2] = "\\'";
        preg_replace($pattern, $replacement, $value);
        return $value;
    }

    //public function sanitize_sql($in)
    //{
    //    return $this->escape($in);
    //}

    function _where($key, $value = NULL, $type = 'AND ', $escape = NULL)
    {
        if (!is_array($key)) {
            $key = array($key => $value);
        }
        if (count($key) == 1 && isset($key[0]) && $key[0] == '') {
            return $this;
        }
        foreach ($key as $k => $v) {
            $prefix = (count($this->ar_where) == 0) ? '' : $type;
            if (!is_null($v)) {
                if (is_array($v)) {

                } else {
                    if ($this->_has_operator($v) && (empty($k) || is_numeric(substr($k, 0, 1)))) {
                        $this->ar_where[] = $prefix . $v;
                        continue;
                    }
                    $v = $this->escape($v);
                }
                if (!$this->_has_operator($k)) {
                    $k .= '=';
                }
            }
            if (is_array($v)) {
                foreach ($v as $minorKey) {
                    $prefix = (count($this->ar_where) == 0) ? '' : $type;
                    $minorV = $this->escape($minorKey);
                    $this->ar_where[] = $prefix . $k . '\'' . $minorV . '\'';
                }
            } else {
                if ($k != '') {
                    if (!$this->_has_operator($k)) {
                        $k .= '=';
                    }
                }
                if (substr($v, 0, 2) == "0x" && preg_match("/[^0-9a-f]/i", substr($v, 2)) == 0)
                    $this->ar_where[] = $prefix . $k . $v;
                else $this->ar_where[] = $prefix . $k . '\'' . $v . '\'';
            }
        }
        return $this;
    }

    function _has_operator_without_space($str)
    {
        $str = trim($str);
        //if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
        if (!preg_match("/(<|>|!|=|is null|is not null)/i", $str)) {
            return FALSE;
        }
        return TRUE;
    }

    function _has_operator($str)
    {
        $str = trim($str);
        //if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
        if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
            return FALSE;
        }
        return TRUE;
    }

    public function sanitizeTableInput($tableName, $dataArray){
        $returnArray = array();

        $this->execute("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='" . $this->db_name . "' AND TABLE_NAME='$tableName';", 'tableColumns');

        $num_results = $this->num_rows('tableColumns');
        for($i = 0; $i < $num_results; $i++) {
            $columnName = $this->result('COLUMN_NAME', $i, 'tableColumns');
            if(isset($dataArray[$columnName])) {
                $columnType = strtolower($this->result('DATA_TYPE', $i, 'tableColumns'));
                switch($columnType) {
                    case 'bigint':
                    case 'int':
                    case 'tinyint':
                        $returnArray[$columnName] = (int)$dataArray[$columnName];
                        break;
                    case 'decimal':
                        $columnTypeDetail = $this->result('COLUMN_TYPE', $i, 'tableColumns');
                        $shortStr1 = substr($columnTypeDetail, 0, -1);
                        $arrayStr = explode(',', $shortStr1);
                        $numDecimal = trim($arrayStr[1]);

                        if((int)$numDecimal == 0) $returnArray[$columnName] = (int)$dataArray[$columnName];
                        else $returnArray[$columnName] = round((float)$dataArray[$columnName], (int)$numDecimal);

                        break;
                    default:
                        if((is_array($dataArray[$columnName]))) {
                            if(!empty($dataArray[$columnName])) $returnArray[$columnName] = sanitize_sql_string(json_encode($dataArray[$columnName]));
                        } else $returnArray[$columnName] = sanitize_sql_string($dataArray[$columnName]);
                }
            }
        }

        return $returnArray;
    }


    private function log_table()
    {
        if (!isset($this->log_table_array[$this->ar_table]))
            $this->log_table_array[$this->ar_table] = array();
        if (!isset($this->log_table_array[$this->ar_table][$this->ar_query_type]))
            $this->log_table_array[$this->ar_table][$this->ar_query_type] = 0;
        $this->log_table_array[$this->ar_table][$this->ar_query_type]++;
    }

    private function _format_select($cache = false)
    {
        $_select = implode(',', $this->ar_select);
        $cache_string = ($cache == true ? 'SQL_CACHE ' : '');
        $_query = "SELECT " . $cache_string . $_select . " FROM " . $this->ar_table . $this->ar_join;
        if (count($this->ar_where) > 0) {
            $_query .= " WHERE " . implode(' ', $this->ar_where);
        }
        if (count($this->ar_order) > 0) {
            $_query .= " ORDER BY " . implode(', ', $this->ar_order);
        }
        if ($this->ar_limit > 0) {
            $_query .= " LIMIT " . intval($this->ar_limit);
        }
        $_query .= ';';
        return $_query;
    }

    private function _format_update()
    {
        $_set = implode(',', $this->ar_update);
        $_query = "UPDATE " . $this->ar_table . " SET " . $_set;
        if (count($this->ar_where) > 0) {
            $_query .= " WHERE " . implode(' ', $this->ar_where);
        }
        if (count($this->ar_order) > 0) {
            $_query .= " ORDER BY " . implode(', ', $this->ar_order);
        }
        if ($this->ar_limit > 0) {
            $_query .= " LIMIT " . intval($this->ar_limit);
        }
        $_query .= ';';
        return $_query;
    }

    private function _format_insert()
    {
        $_set = implode(',', $this->ar_update);
        $_query = "INSERT INTO " . $this->ar_table . " SET " . $_set;
        $_query .= ';';
        return $_query;
    }

    private function _format_delete()
    {
        $_query = "DELETE FROM " . $this->ar_table;
        if (count($this->ar_where) > 0) {
            $_query .= " WHERE " . implode(' ', $this->ar_where);
        }
        $_query .= ';';
        return $_query;
    }

    private function ar_clean()
    {
        $this->ar_table = '';
        $this->ar_join = '';
        $this->ar_limit = 0;
        $this->ar_select = array();
        $this->ar_where = array();
        $this->ar_order = array();
        $this->ar_update = array();
    }

}

/**
 * \class rdb
 * \brief Rapid Database Connection
 *
 * rdb is a PHP class that will contact a MySQL database
 * and provide the returned output in a result function.
 *
 * Copyright 2010 International Academy of Science
 *
 * The rdb class will be initialized once per PHP session.
 *
 * The rdb->execute can be called multiple times, and the
 * data collected will all be available in a multi-dimensional
 * array.
 *
 * @since  0.001
 * @author Jonathan Eyre eyre.jonathan@gmail.com
 */
?>
