function setSelectedClient(object) {
    var list_clients = document
        .getElementById("liste_client")
        .getElementsByClassName("box_client");
    if (editedDNS_index != null) {
        if (confirm("Souhaitez-vous vraiment annuler la modification en cours?")) {
            editedDNS_index = null;
            if (object.id != selectedClient_index && selectedClient_index != null) { //Evite de faire de l'ajax si il click sur le meme domain que précédement.
                //On vide la liste de DNS.
                document.getElementsByTagName("tbody")[0].innerHTML = "";
                //Déselection de l'élément précédent : remise en forme basique
                list_clients[selectedClient_index].style.backgroundColor = "#fff";
                list_clients[selectedClient_index].style.color = "#3F4254";
                //Sélection de l'objet passé en paramètre : mise en forme séléction.
                list_clients[object.id].style.backgroundColor = "#3699FF";
                list_clients[object.id].style.color = "#fff";

                selectedClient_index = object.id;

                //Ajax permettant de récupérer les domaines du client.
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var res = this.response;
                        var list_domain = res["list_domain"]; //Liste des domaines.
                        displayDomainLine(list_domain);

                    } else if (this.readyState == 4) {
                        alert("Une erreur est survenue..");
                    } else if (this.statusText == "parsererror") {
                        alert("Erreur Json");
                    }
                };

                xhr.open("POST", "module/client/select/selectClient.php", true);
                xhr.responseType = "json";
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("idClient=" + encodeURI(object.getAttribute("name"))); //Name == id.
            } else if (selectedClient_index === null) {
                /*Au chargement le PHP charge les infos du premier CLIENT 
                Ici il s'agit de set le selectedClient_index et de changer la mise en forme*/

                //Déselection de l'élément précédent : remise en forme basique
                list_clients[0].style.backgroundColor = "#fff";
                list_clients[0].style.color = "#3F4254";
                //Sélection de l'objet passé en paramètre : mise en forme séléction.
                list_clients[object.id].style.backgroundColor = "#3699FF";
                list_clients[object.id].style.color = "#fff";

                selectedClient_index = object.id;
            }
        }
    } else { //L'utilisateur n'avait aucune modification de DNS en cours.
        if (object.id != selectedClient_index && selectedClient_index != null) { //Evite de faire de l'ajax si il click sur le meme domain que précédement.
            //On vide la liste de DNS.
            document.getElementsByTagName("tbody")[0].innerHTML = "";
            //Déselection de l'élément précédent : remise en forme basique
            list_clients[selectedClient_index].style.backgroundColor = "#fff";
            list_clients[selectedClient_index].style.color = "#3F4254";
            //Sélection de l'objet passé en paramètre : mise en forme séléction.
            list_clients[object.id].style.backgroundColor = "#3699FF";
            list_clients[object.id].style.color = "#fff";

            selectedClient_index = object.id;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = this.response;
                    var list_domain = res["list_domain"];
                    displayDomainLine(list_domain);

                } else if (this.readyState == 4) {
                    alert("Une erreur est survenue..");
                } else if (this.statusText == "parsererror") {
                    alert("Erreur Json");
                }
            };

            xhr.open("POST", "module/client/select/selectClient.php", true);
            xhr.responseType = "json";
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("idClient=" + encodeURI(object.getAttribute("name"))); //Name == id.
        } else if (selectedClient_index === null) {

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = this.response;
                    var clients = Array.from(list_clients);

                    clients.forEach(function (client, index) {
                        if (client.getAttribute("name") == res["first_clientDomain"].id) {
                            //Sélection de l'objet passé en paramètre : mise en forme séléction.
                            list_clients[client.id].style.backgroundColor = "#3699FF";
                            list_clients[client.id].style.color = "#fff";

                            selectedClient_index = client.id;
                        }
                    });

                } else if (this.readyState == 4) {
                    alert("Une erreur est survenue..");
                } else if (this.statusText == "parsererror") {
                    alert("Erreur Json");
                }
            };

            xhr.open("POST", "module/client/first_clientHaveDomain.php", true);
            xhr.responseType = "json";
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(); //Name == id.
        }
    }

}