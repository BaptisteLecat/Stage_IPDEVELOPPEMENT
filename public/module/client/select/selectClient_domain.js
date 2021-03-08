function setSelectedClient(clientId) {
    var clients = Array.from(list_clients);

    clients.forEach(function (client, index) {
        if (client.getAttribute("name") == clientId) {
            if (selectedClient_index != null) {
                //Déselection de l'élément précédent : remise en forme basique
                clients[selectedClient_index].style.backgroundColor = "#fff";
                clients[selectedClient_index].style.color = "#3F4254";
                //Sélection de l'objet passé en paramètre : mise en forme séléction.
                clients[client.id].style.backgroundColor = "#3699FF";
                clients[client.id].style.color = "#fff";

                selectedClient_index = client.id;
            } else {
                //Sélection de l'objet passé en paramètre : mise en forme séléction.
                clients[client.id].style.backgroundColor = "#3699FF";
                clients[client.id].style.color = "#fff";

                selectedClient_index = client.id;
            }
        }
    });
}