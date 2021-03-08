<?php
/**
 *  File call on AJAX to update the data of a DNS Record.
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

    $DNSRecordManager = new DNSRecordManager();
    $DNSFieldManager = new DNSFieldManager();

    $idDNS = $_POST["idDNSRecord"];
    $arrayDNSInfo = json_decode($_POST["arrayDNSInfo"], true);
    //$arrayDNSInfo = ["host" => "testdehost", "value" => "testdevalue", "idType" => 3];
    $list_DNSField = array();

    $success = 0;

    //Loading of the DNSFieldList.
    $resultloadDNSField = $DNSFieldManager->loadDNSField();
    $list_DNSField = $resultloadDNSField["list_DNSField"];

    $breakState = false; //Permet de break le premier foreach.

    foreach ($list_client as $client) {
        foreach ($client->listDNSRecord() as $DNSRecord) {
            if ($DNSRecord->getId() == $idDNS) {
                $DNSRecordManager->updateDNSRecord($arrayDNSInfo["host"], $arrayDNSInfo["value"], $arrayDNSInfo["idType"], $DNSRecord, $list_DNSField);
                $success = 1;
                $breakState = true;
                break;
            }
        }
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
