<?php

function loadClient($clientManager)
{
    $list_client = array();
    $list_client = $clientManager->loadClient()["list_client"];

    return $list_client;
}

function loadClientDomain($client, $domainManager)
{
    $domainManager->loadDomainFromClient($client);
}

function loadDNSField($DNSFieldManager)
{
    return $DNSFieldManager->loadDNSField()["list_DNSField"];
}

function loadClientDNSRecord($client, $list_DNSField, $DNSRecordManager)
{
    foreach ($client->getList_Domains() as $domain) {
        $DNSRecordManager->loadDNSRecordFromDomain($domain, $list_DNSField);
    }
}
