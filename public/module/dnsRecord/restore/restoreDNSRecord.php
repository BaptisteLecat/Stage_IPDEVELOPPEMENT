<?php

/**
 *  File call on AJAX to restore a DNS record
 */

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
            //We search the DNS object who have the same id as the DNS we want to restore.
            if ($DNSRecord->getId() == $idDNS) {
                $DNSRecordManager->archiveDNSRecord($DNSRecord, false);
                $success = 1;
                $breakState = true;
                break;
            }
        }

        //Allow to cut the loop when we find the DNS.
        if ($breakState) {
            break;
        }
    }

    $_SESSION["list_client"] = serialize($list_client);
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

$response = ["success" => $success];

echo json_encode($response);
