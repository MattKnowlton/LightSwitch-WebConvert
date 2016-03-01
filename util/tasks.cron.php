<?php

if(isset($CRON) && $CRON == true){


}

$files = glob('uploaded/query:*.txt');

if(!empty($files)){
    foreach($files as $file){
        $querySuccess = true;
        $queries = file_get_contents($file);
        $queries = str_replace('\r', '', $queries);
        $queries = str_replace('\n', '', $queries);
        $queries = explode('|$|', $queries);
        foreach($queries as $query){
            $query = trim($query);
            if(strlen($query) > 15){
                if(!$dbConn->execute($query)) $querySuccess = false;
            }
        }
        if($querySuccess) unlink($file);
    }

    $images = glob('uploaded/*.jpg');
    foreach($images as $image) {
        $imageName = basename($image);
        rename($image, 'files/'.$imageName);
    }
}
