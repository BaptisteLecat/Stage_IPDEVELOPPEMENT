function insertDomain_modal() {

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
            var navOpt1 = document.getElementsByClassName("nav-opt")[0];
            navOpt1.addEventListener('click', (e) => {
                if (navOpt1 !== e.target) return;
                e.preventDefault();
                nav_modalDomain(e);
            });
            var navOpt2 = document.getElementsByClassName("nav-opt")[1];
            navOpt2.addEventListener('click', (e) => {
                if (navOpt2 !== e.target) return;
                e.preventDefault();
                nav_modalDomain(e);
            });

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "form/formRouter.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("view=form&form=insertDomain&idDomain=" + encodeURI(idDomain) + "&idClient=" + encodeURI(idClient) + "&controller=" + encodeURI(controller));
}