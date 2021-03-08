function DNSZone_modal() {
    if (selectedDomain_index != null) { //Si un domaine est sélectionné.
        //Récupération de l'id du domain sélectionné.
        idDomain = document.getElementById("liste_domaine").getElementsByClassName("box_domaine")[selectedDomain_index].getAttribute("name");

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.response;
                //Suppression de la modal si une est affichée.
                (document.getElementsByClassName("modal_mask")[0] != null) ? document.getElementsByClassName("modal_mask")[0].remove() : null;
                //Ajout de la modal dans la page.
                document.getElementsByTagName("body")[0].innerHTML += res["content"];

                //Gestion du menu modal, ajout des listener sur les click.
                var navOpt1 = document.getElementsByClassName("nav-opt")[0];
                navOpt1.addEventListener('click', (e) => {
                    if (navOpt1 !== e.target) return;
                    e.preventDefault();
                    nav_modalDNS(e);
                });
                var navOpt2 = document.getElementsByClassName("nav-opt")[1];
                navOpt2.addEventListener('click', (e) => {
                    if (navOpt2 !== e.target) return;
                    e.preventDefault();
                    nav_modalDNS(e);
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
        xhr.send("view=form&form=insertDNSZone&idDomain=" + encodeURI(idDomain) + "&controller=" + encodeURI(controller));
    }
}

function displayMXPriorityInput() {
    var priority_container = document.getElementsByClassName("form-priority")[0];
    priority_container.style.margin = "20px auto 0px auto";

    var h6 = document.createElement("h6");
    h6.innerText = "Priorité";
    priority_container.appendChild(h6);

    var input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("name", "priority");
    input.setAttribute("min", 0);
    input.setAttribute("max", 300);
    input.classList.add("form-priority_input");
    input.value = 0;
    //Ajout d'un écouteur pour détecter le changement de la valeur et changer l'affichage du champs généré.
    input.addEventListener('change', (e) => {
        generatorDNS(e);
    });
    priority_container.appendChild(input);
}