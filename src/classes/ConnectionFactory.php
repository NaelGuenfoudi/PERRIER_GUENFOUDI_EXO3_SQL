<?php

class ConnectionFactory {
    public static $config;
    public static $bd;

    public static function setConfig($file) {
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection() : PDO {
        try {
            $driver = self::$config['driver'];
            $host = self::$config['host'];
            $dbname = self::$config['dbname'];
            $dsn = "$driver:host=$host; dbname=".$dbname;
            $username = self::$config['username'];
            $password = self::$config['password'];

            self::$bd = new PDO($dsn,$username,$password, [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false,]);

        } catch (Exception $e) {
            die('erreur: '.$e->getMessage());
        }
        return self::$bd;
    }
}
