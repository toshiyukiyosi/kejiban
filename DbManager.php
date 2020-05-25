<?php
function getDb(){
    $dsn = 'mysql:dbname=chatTest_db;host=localhost;charset=utf8';
    $DB_usr = 'root';
    $DB_pass = '';
    $db = new PDO($dsn,$DB_usr,$DB_pass);
    return $db;
}