<?php 

namespace App;

//Conf of database.
require_once(__DIR__.'/../config/settings.php');


class PdoFactory
{
    protected static $pdo;

    public static function init(){
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DBNAME;
        $user = USER;
        $password = PASSWORD;
        self::$pdo = new \PDO($dsn, $user, $password);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getPdo()
    {
        return self::$pdo;
    }
}