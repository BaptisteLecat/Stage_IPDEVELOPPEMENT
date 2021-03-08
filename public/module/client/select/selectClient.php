<?php
session_start();
require_once "../../../../App/Autoloader.php";

use App\Autoloader;
use App\PdoFactory;

Autoloader::register();
PdoFactory::init();
$list_client = unserialize($_SESSION["list_client"]);
$idClient = $_POST["idClient"];

$success = 0;
$list_domain = array();


foreach ($list_client as $client) {
    if($client->getId() == $idClient){
        $list_domain = $client->getList_Domains();
        $success = 1;
    }
}

$response = ["success" => $success, "list_domain" => $list_domain];

echo json_encode($response);