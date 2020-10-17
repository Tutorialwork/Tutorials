<?php
$host = "localhost";
$name = "test";
$user = "root";
$passwort = "";
try{
    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo "SQL Error: ".$e->getMessage();
}
