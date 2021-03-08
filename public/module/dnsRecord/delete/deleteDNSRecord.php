<?php

require_once "../../../../App/Autoloader.php";

use App\Autoloader;
use App\Model\DNSRecordManager;
use App\PdoFactory;

try {
    session_start();
    Autoloader::register();
    PdoFactory::init();
    $DNSRecordManager = new DNSRecordManager();
    $list_client = unserialize($_SESSION["list_client"]);
    $idDNS = $_POST["idDNSRecord"];
    $success = 0;

    $breakState = false;
    foreach ($list_client as $client) {
        foreach ($client->listDNSRecord() as $DNSRecord) {
            if ($DNSRecord->getId() == $idDNS) {
                $DNSRecordManager->deleteDNSRecord($DNSRecord);
                $DNSRecord->delete();
                $success = 1;
            }
        }
    }

    $_SESSION["list_client"] = serialize($list_client);
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

$response = ["success" => $success];

echo json_encode($response);
