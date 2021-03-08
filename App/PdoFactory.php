<?php 

namespace App;

//Conf of database.
require_once(__DIR__.'/../config/settings.php');
/*define("HOST", "185.123.72.136");
define("DBNAME", "doli-dev01");
define("USER", "doli-dev01");
define("PASSWORD", "Pij79UKuu9IAXsxH");*/

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