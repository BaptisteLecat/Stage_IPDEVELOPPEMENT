<?php

/**
 *  File call on AJAX to load the list of DNS link to a client
 */

require_once "../../../../App/Autoloader.php";

use App\Autoloader;
use App\Model\DNSRecordManager;
use App\Model\DNSFieldManager;
use App\PdoFactory;

try {
    session_start();
    Autoloader::register();
    PdoFactory::init();

    $list_client = unserialize($_SESSION["list_client"]);
    $idDomain = $_POST["idDomain"];

    $success = 0;
    $list_DNSRecord = array();

    foreach ($list_client as $client) {
        foreach ($client->getList_Domains() as $domain) {
            if ($domain->getId() == $idDomain) {
                $list_DNSRecord = $domain->getList_DNSRecord();
                $success = 1;
                break;
            }
        }
    }

    $_SESSION["list_client"] = serialize($list_client);
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

$response = ["success" => $success, "list_DNSRecord" => $list_DNSRecord];

echo json_encode($response);
