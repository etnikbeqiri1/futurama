<?php

class Database
{
/*    static private $serverName = '185.61.137.174';
    static private $user = 'merrlike_futurama';
    static private $password = 'shkumbin111';
    static private $databaseName = 'merrlike_futurama';*/
    static private $serverName = 'localhost';
    static private $user = 'root';
    static private $password = '';
    static private $databaseName = 'futurama';
    static private $conn;


    static public function setConn()
    {
        try {
            $conn = new PDO("mysql:host=".Database::$serverName.";dbname=".Database::$databaseName,
                Database::$user, Database::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        self::$conn = $conn;
    }

    static public function getConn(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(self::$conn == null || !isset(self::$conn)){
            self::setConn();
        }
        return self::$conn;
    }
}
