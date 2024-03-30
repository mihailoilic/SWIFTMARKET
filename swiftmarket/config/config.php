<?php

define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"]."/swiftmarket");

define("ENV_FILE", ABSOLUTE_PATH."/config/.env");
define("LOG_FILE", ABSOLUTE_PATH."/data/log.txt");
define("ERROR_LOG_FILE", ABSOLUTE_PATH."/data/errors.txt");

define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));

function env($flag){
    $lines = file(ENV_FILE);
    $result = "";
    foreach($lines as $line){
        list($name, $value) = explode("=", trim($line));
        if($name == $flag){
            $result = $value;
        }
    }
    return $result;
}
