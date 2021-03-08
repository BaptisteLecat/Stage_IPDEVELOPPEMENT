<?php

namespace App\Model\Entity;

use JsonSerializable;

class Client implements JsonSerializable
{
    //PHP 7.4.0 pour le typage.
    private $id;
    private $name;

    private $list_Domains;

    function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        $this->list_Domains = array();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getList_Domains()
    {
        return $this->list_Domains;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setList_Domains($value)
    {
        $this->list_Domains = $value;
    }

    public function addDomain($domain)
    {
        array_push($this->list_Domains, $domain);
    }

    public function deleteDomain($domain)
    {
        unset($this->list_Domains[array_search($domain, $this->list_Domains)]);
    }

    public function nbDomain()
    {
        return count($this->list_Domains);
    }

    public function nbDNSRecord()
    {
        $nbDNSRecord = 0;

        foreach ($this->list_Domains as $domain) {
            $nbDNSRecord += $domain->nbDNSRecord();
        }

        return $nbDNSRecord;
    }

    public function listDNSRecord()
    {
        $list_DNSRecord = array();

        foreach ($this->list_Domains as $domain) {
            //array_push($list_DNSRecord, $domain->getList_DNSRecord());
            foreach($domain->getList_DNSRecord() as $DNSRecord){
                array_push($list_DNSRecord, $DNSRecord);
            }
        }

        return $list_DNSRecord;
    }
}
