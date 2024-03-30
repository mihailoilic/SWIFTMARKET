<?php

require_once "config.php";
require_once ABSOLUTE_PATH."/models/functions.php";

$user_obj = false;
check_session();
create_log(LOG_FILE, "A user has accessed this page.");

try {
    $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
    echo $ex->getMessage();
}

function select_query($table, $custom = false){
    global $conn;
    if($custom){
        $query = $conn->query("$table");
    }
    else {
        $query = $conn->query("SELECT * FROM $table");
    }
    return $query->fetchAll();
}


