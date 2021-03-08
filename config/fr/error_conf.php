<?php

define("ERROR", "Erreur");
define("ERROR_SYNTAX", "Erreur de syntaxe");
define("ERROR_OCCURRED", "Une erreur est survenue..");
/* ----------------------- */

/* Syntax DNS ERROR */
define("DNS_SUBDOMAIN_SYNTAX", "Le sous-domaine doit être sous la forme suivante: exemple.fr");
define("DNS_TYPE_UNKNOWN", "Le type de DNS semble inconnu.");
define("DNS_MXPRIORITY_OUTRANGE", "La valeur de la priorité doit être comprise entre 0 et 300.");
define('ERROR_DNS_ARGUMENTS_NB', 'Le nombre d\arguments est incorrect.');
define('ERROR_DNS_ARGUMENTS', 'Les arguments semblent incorrect.');


/* ----------------------- */

/* Domain Syntax ERROR */
define("DOMAIN_NAME_SYNTAX", "Le nom de domaine doit être sous la forme suivante : exemple.fr");
define("DNS_SERVER_SYNTAX", "Le serveur DNS doit être sous la forme d'une IPV4.");
/* ----------------------- */

/* Modal ERROR */
define("ERROR_INSERT", "L'insertion du nouvel élément à échoué.");
define("ERROR_UPDATE", "La modification n'a pas pu s'effectuer.");
define("ERROR_DELETE", "La suppression n'a pas pu s'effectuer.");
/* ----------------------- */

/* Loading ERROR */
define('ERROR_LOADING', 'Les informations n\'ont pas pu être chargées.');
define('ERROR_LOAD_JS', 'Les fichiers Javascript n\'ont pas pu être chargés.');
define('ERROR_LOAD_CSS', 'Les fichiers CSS n\'ont pas pu être chargés.');
define('ERROR_LOAD_HEAD', 'L\'entête de la page n\'a pas pu être chargée.');
/* ----------------------- */

/* Module ERROR */
define('ERROR_UNDEFINED_MODULE', 'Erreur aucun module ne semble être chargé!');
define('ERROR_DASHBOARD_DNS', 'Le module DNS ne peut être affiché.');
define('ERROR_DASHBOARD_DISPLAY', 'Le module Display ne peut être affiché.');
define('ERROR_DASHBOARD_CLIENT', 'Le module Client ne peut être affiché.');
define('ERROR_DASHBOARD_DOMAIN', 'Le module Domaine ne peut être affiché.');
/* ----------------------- */

define('ERROR_FILE_NOTFOUND', 'Le fichier est introuvable');
define('ERROR_FILE_SETTINGS', 'Le fichier de paramètres est introuvable.');

?>