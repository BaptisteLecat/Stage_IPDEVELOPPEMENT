<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../../../App/Autoloader.php";

use App\Autoloader;
use App\PdoFactory;

session_start();
Autoloader::register();
PdoFactory::init();
$list_client = unserialize($_SESSION["list_client"]);
$first_clientDomain = null;
$success = 0;

foreach ($list_client as $client) {
    if (count($client->getList_Domains()) > 0) {
        $first_clientDomain = $client;
        $success = 1;
        break;
    }
}

$response = ["success" => $success, "first_clientDomain" => $first_clientDomain];

echo json_encode($response);


