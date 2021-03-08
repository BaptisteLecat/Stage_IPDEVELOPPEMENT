<?php

namespace App\Model\Entity;

use JsonSerializable;

class DNS_Record_STANDARD extends DNS_Record implements JsonSerializable
{

    function __construct(int $id, string $subDomain, string $target, $deleted_on, $created_on, $modified_on, $domainObject, $DNS_FieldObject)
    {
        parent::__construct($id, $subDomain, $target, $deleted_on, $created_on, $modified_on, $domainObject, $DNS_FieldObject);

        //Allow to add this DNS_Record to the list_DNSRecords of Domain.
        $this->domainObject->addDNSRecord($this);
        //Allow to add this DNS_Record to the list_DNSRecords of DNS_Field.
        $this->DNS_FieldObject->addDNSRecord($this);
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'subDomain' => $this->subDomain,
            'target' => $this->target,
            'deleted_on' => $this->deleted_on,
            'created_on' => $this->created_on,
            'modified_on' => $this->modified_on,
            'DNS_FieldObject' => $this->DNS_FieldObject->jsonSerialize(),
            //'domainObject' => $this->domainObject->jsonSerialize(),
            'timeBeforeDeleted' => parent::timeBeforeDeleted(),
            'DNS_type' => "DNS_Record_STANDARD",
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSubDomain()
    {
        return $this->subDomain;
    }

    public function getTarget()
    {
        return $this->target;
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

    public function getDomainObject()
    {
        return $this->domainObject;
    }

    public function getDNSFieldObject()
    {
        return $this->DNS_FieldObject;
    }

    public function setDeletedOn($deleted_on)
    {
        $this->deleted_on = $deleted_on;
    }

    public function delete()
    {
        parent::delete();
    }

    public function timeBeforeDeleted()
    {
        return parent::timeBeforeDeleted();
    }
}
