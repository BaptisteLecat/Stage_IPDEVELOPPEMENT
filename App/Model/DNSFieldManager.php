<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\DNS_Field;
use \PDOException;
use \Exception;

/**
 * Allow to interact with the llx_dns_fields table in Database.
 * Use PdoFactory.
 */
class DNSFieldManager extends PdoFactory
{
    /**
     * Function to load all DNS fields.
     *
     * @return array(Tinyint) $response[success]
     */
    public function loadDNSField()
    {
        $response = ["success" => 0];
        $list_DNSField = array();

        try {
            $request = PdoFactory::$pdo->prepare("SELECT id, label, regex, exception_message FROM llx_dns_fields");
            if ($request->execute()) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        $DNS_Field = new DNS_Field($result["id"], $result["label"], $result["regex"], $result["exception_message"]);
                        array_push($list_DNSField, $DNS_Field);
                        $response["success"] = 1;
                    }
                    $response["list_DNSField"] = $list_DNSField;
                }
            }
        } catch (PDOException $e) {
            throw new Exception($e);
        }

        return $response;
    }
}
