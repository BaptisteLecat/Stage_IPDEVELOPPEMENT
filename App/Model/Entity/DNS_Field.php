<?php

namespace App\Model\Entity;

use JsonSerializable;

class DNS_Field implements JsonSerializable
{
    private $id;
    private $label;
    private $regex;
    private $exceptionMessage;

    private $list_DNSRecords;

    function __construct(int $id, string $label, string $regex, string $exceptionMessage){
        $this->id = $id;
        $this->label = $label;
        $this->regex = $regex;
        $this->exceptionMessage = $exceptionMessage;

        $this->list_DNSRecords = array();
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'label' => $this->label,
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel(){
        return $this->label;
    }

    public function getRegex()
    {
        return $this->regex;
    }

    public function getExceptionMessage()
    {
        return $this->exceptionMessage;
    }

    public function getList_DNSRecord(){
        return $this->list_DNSRecords;
    }

    public function addDNSRecord($DNSRecord){
        array_push($this->list_DNSRecords, $DNSRecord);
    }

    public function deleteDNSRecord($DNSRecord){
        unset($this->list_DNSRecords[array_search($DNSRecord, $this->list_DNSRecords)]);
    }
}
