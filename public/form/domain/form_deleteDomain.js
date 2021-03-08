function deleteDomain_modal() {

    idDomain = (selectedDomain_index != null) ? document.getElementById("liste_domaine").getElementsByClassName("box_domaine")[selectedDomain_index].getAttribute("name") : null;
    idClient = (selectedClient_index != null) ? document.getElementById("liste_client").getElementsByClassName("box_client")[selectedClient_index].getAttribute("name") : null;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            (document.getElementsByClassName("modal_mask")[0] != null) ? document.getElementsByClassName("modal_mask")[0].remove() : null;
            document.getElementsByTagName("body")[0].innerHTML += res["content"];
            //Ajout d'un écouteur sur le changement du type sélectionné.
            document.getElementsByName("client-selector")[0].addEventListener("change", function (event) {
                idClient = document.getElementById("liste_client").getElementsByClassName("box_client")[event.target.selectedOptions[0].value].getAttribute("name");
            });

            //Gestion du menu modal, ajout des listener sur les click.
            document.getElementsByClassName("nav-opt")[0].addEventListener('click', (e) => {
                e.preventDefault();
                nav_modalDomain(e);
            });
            document.getElementsByClassName("nav-opt")[1].addEventListener('click', (e) => {
                e.preventDefault();
                nav_modalDomain(e);
            });

            //Affichage des valeurs précédente.
            var domain = document.getElementById("liste_domaine").getElementsByClassName("box_domaine")[selectedDomain_index];
            var domainName = domain.getElementsByTagName("h3")[0].innerText;
            var serverDNS = domain.getElementsByTagName("p")[0].innerText;
            //console.log(domain.getElementsByTagName("input")[0]);
            var manageDNS = domain.getElementsByTagName("input")[0].checked;

            var input = document.getElementsByClassName("modal_content")[0].getElementsByTagName("form")[0].getElementsByTagName("input");
            input[0].value = domainName;
            input[1].value = serverDNS;
            input[2].checked = manageDNS;

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "form/formRouter.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("view=form&form=updateDomain&idDomain=" + encodeURI(idDomain) + "&action=delete&idClient=" + encodeURI(idClient) + "&controller=" + encodeURI(controller));
}