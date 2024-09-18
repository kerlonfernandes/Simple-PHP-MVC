<?php

require_once('intern/debug.php');

// Debug::enable(true, __DIR__ . '/var/log/php/error.log');

$config_data = file_get_contents(__DIR__."/config.json");

$config_array = json_decode($config_data, true);

if (json_last_error() != JSON_ERROR_NONE) {
    return;
} 

date_default_timezone_set('America/Sao_Paulo');

define("URL", "https://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'] . "?"));

define("MYSQL_CONFIG", $config_array["database"]);

