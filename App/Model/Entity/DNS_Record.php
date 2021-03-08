<?php

namespace App\Model\Entity;

use DateTime;
use JsonSerializable;

abstract class DNS_Record
{
    protected $id;
    protected $subDomain;
    protected $target;
    protected $deleted_on;
    protected $created_on;
    protected $modified_on;

    protected $domainObject;
    protected $DNS_FieldObject;

    function __construct(int $id, string $subDomain, string $target, $deleted_on, $created_on, $modified_on, $domainObject, $DNS_FieldObject)
    {
        $this->id = $id;
        $this->subDomain = $subDomain;
        $this->target = $target;
        $this->deleted_on = $deleted_on;
        $this->created_on = $created_on;
        $this->modified_on = $modified_on;

        $this->domainObject = $domainObject;
        $this->DNS_FieldObject = $DNS_FieldObject;
    }

    protected function timeBeforeDeleted()
    {
        $time = null;
        if($this->deleted_on != null){
            $origin = new DateTime(date("Y-m-d H:i:s", strtotime("-1 day")));
            $target = new DateTime($this->deleted_on);
            $interval = $origin->diff($target, true);
            $time = $interval->format('%a');
        }

        return $time;
    }

    protected function delete()
    {
        //Allow to delete this DNS_Record to the list_DNSRecords of DNS_Field.
        $this->DNS_FieldObject->deleteDNSRecord($this);
        //Allow to delete this DNS_Record to the list_DNSRecords of Domain.
        $this->domainObject->deleteDNSRecord($this);
    }
}
