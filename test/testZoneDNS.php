<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function splitInput($input)
{
    $list_DNSArg = array();
    $list_line = array();
    $list_element = array();


    $list_line = explode("\n", $input); //Découpage ligne par ligne.

    foreach ($list_line as $line) {
        $list_element = explode(" ", $line); //Séparation par espace.
        $dns =
            [
                "args" => array()
            ];
        foreach ($list_element as $element) {
            $breakState = false;

            if ($element != "") { //Récupération uniquement des mots.
                if (strlen($element) > 0) {
                    array_push($dns["args"], $element);
                }
            }

            if (count($dns["args"]) > 4) { // Doit faire moins de 4 arguments max
                throw new Exception("Too many arguments..");
                $breakState = true;
                break;
            }
        }

        if ($breakState == false) {
            array_push($list_DNSArg, $dns);
        }
    }

    return $list_DNSArg;
}

$input = '@       MX      0 ipdev-fr.mail.protection.outlook.com.';

echo '<pre>';
$list_dns = splitInput($input);
foreach ($list_dns as $dns) {
    var_dump($dns["args"]);
    var_dump(count($dns["args"]));
}
echo '</pre>';
