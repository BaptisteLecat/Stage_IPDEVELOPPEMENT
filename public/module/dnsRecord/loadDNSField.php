<?php
require_once "../../../App/Autoloader.php";

use App\Autoloader;
use App\Model\DNSFieldManager;
use App\PdoFactory;

Autoloader::register();
PdoFactory::init();

$DNSFieldManager = new DNSFieldManager();
$list_DNSField = array();
$success = 0;

try {
    $list_DNSField = $DNSFieldManager->loadDNSField()["list_DNSField"];
    $success = 1;
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

$response = ["success" => $success, "list_DNSField" => $list_DNSField];

echo json_encode($response);
