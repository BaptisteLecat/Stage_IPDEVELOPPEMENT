<?php

function clientHaveDomain($list_client)
{
    $list_clientDomain = array();
    foreach ($list_client as $client) {
        if (count($client->getList_Domains()) > 0) {
            array_push($list_clientDomain, $client);
            break;
        }
    }
    return $list_clientDomain;
}

//Utile pour le mode domain -> affiche tout les domaines
function allDomain($list_client)
{
    $list_domain = array();
    foreach ($list_client as $client) {
        foreach ($client->getList_Domains() as $domain) {
            array_push($list_domain, $domain);
        }
    }
    return $list_domain;
}

function getNbDomainAllClient($list_client)
{
    $nbDomain = 0;
    foreach ($list_client as $client) {
        $nbDomain += $client->nbDomain();
    }
    return $nbDomain;
}

function getNbDomainFirstClient($list_client){
    return count($list_client[0]->getList_Domains());
}