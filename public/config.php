<?php

// start session 
session_start();
// home
$path = '/php_users_media/public/';

$GLOBALS['path'] = $path;

// db PDO data -> local
$mysql_host = "localhost";
$mysql_database = "php_users_media";
$mysql_user = "XXXXXXXXXXXXXX";
$mysql_password = "XXXXXXXXXXXXXXX";
try{

    $GLOBALS['con'] = new PDO(
        "mysql:host=" . $mysql_host . ";dbname=" . $mysql_database,
        $mysql_user,
        $mysql_password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
}catch(PDOException $e){
    switch ($e->getCode()) {
        case 2002:
            echo 'MySQL server is not on given address';
            break;
        case 1049:
            echo 'Wrong database name';
            break;
        case 1045:
            echo 'Wrong user name and/or password';
            break;
        default:
            echo $e->getCode();
            break;
    }
    exit;
}
?>
