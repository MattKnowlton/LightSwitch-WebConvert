<?php

function distinctOptions($table, $field, $where = []){
    global $dbConn;

    $dbConn->select('DISTINCT('.$field.')')->from($table);
    $dbConn->where($where)->get();

    $result = $dbConn->export_result();
    foreach($result as &$row){
        $row = $row[$field];
    }
    return $result;
}
