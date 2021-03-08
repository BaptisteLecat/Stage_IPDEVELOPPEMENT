<?php

namespace App\Model\Entity;

use JsonSerializable;

class Domain implements JsonSerializable
{
    private $id;
    private $domainName;
    private $serverDNS;
    private $manageDNS;
    private $deleted_on;
    private $created_on;
    private $modified_on;

    private $clientObject;
    private $list_DNSRecords;

    function __construct(int $id, string $domainName, string $serverDNS, int $manageDNS, $deleted_on, $created_on, $modified_on, $clientObject)
    {
        $this->id = $id;
        $this->domainName = $domainName;
        $this->serverDNS = $serverDNS;
        $this->manageDNS = $manageDNS;
        $this->deleted_on = $deleted_on;
        $this->created_on = $created_on;
        $this->modified_on = $modified_on;

        $this->clientObject = $clientObject;
        $this->list_DNSRecords = array();

        //Permet d'ajouter ce domaine à la list_Domains du client.
        $this->clientObject->addDomain($this);
    }

    public function jsonSerialize()
    {
        $jsonArray_DNSRecord = array();
        foreach ($this->list_DNSRecords as $DNSRecord) {
            array_push($jsonArray_DNSRecord, $DNSRecord->jsonSerialize());
        }

        return array(
            'id' => $this->id,
            'domainName' => $this->domainName,
            'serverDNS' => $this->serverDNS,
            'manageDNS' => $this->manageDNS,
            'deleted_on' => $this->deleted_on,
            'created_on' => $this->created_on,
            'modified_on' => $this->modified_on,
            'clientObject' => $this->clientObject->jsonSerialize(),
            'list_DNSRecords' => $jsonArray_DNSRecord,
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDomainName()
    {
        return $this->domainName;
    }

    public function getServerDNS()
    {
        return $this->serverDNS;
    }

    public function getManageDNS()
    {
        return $this->manageDNS;
    }

    public function getDeletedOn()
    {
        return $this->deleted_on;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function getModifiedOn()
    {
        return $this->modified_on;
    }

    public function getClientObject()
    {
        return $this->clientObject;
    }

    public function getList_DNSRecord()
    {
        return $this->list_DNSRecords;
    }

    public function setDeletedOn($deleted_on)
    {
        $this->deleted_on = $deleted_on;
    }

    public function addDNSRecord($DNSRecord)
    {
        array_push($this->list_DNSRecords, $DNSRecord);
    }

    public function deleteDNSRecord($DNSRecord)
    {
        unset($this->list_DNSRecords[array_search($DNSRecord, $this->list_DNSRecords)]);
    }

    public function delete()
    {
        $this->clientObject->deleteDomain($this);
    }

    public function nbDNSRecord(){
        return count($this->list_DNSRecords);
    }

    public function domainFormatForm(){
        return ".".$this->domainName.".";
    }
}
