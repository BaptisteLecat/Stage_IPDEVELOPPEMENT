var selectedDomain_index = null;
var selectedClient_index = null;

var editedDNS_index = null;
var arrayDNS_info = null;

var list_domains = document
  .getElementById("liste_domaine")
  .getElementsByClassName("box_domaine");

setSelectedDomain(list_domains[0]);

var list_clients = document
  .getElementById("liste_client")
  .getElementsByClassName("box_client");

setSelectedClient(list_clients[0]);
