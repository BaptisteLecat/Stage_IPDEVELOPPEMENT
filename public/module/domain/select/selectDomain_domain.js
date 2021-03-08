function setSelectedDomain(object, forced) {
    var list_domains = document
        .getElementById("liste_domaine")
        .getElementsByClassName("box_domaine");
    forced = forced || false;

    if (editedDNS_index != null) {
        if (confirm("Souhaitez-vous vraiment annuler la modification en cours?")) {
            editedDNS_index = null;
            if ((object.id != selectedDomain_index && selectedDomain_index != null) || forced) { //Evite de faire de l'ajax si il click sur le meme domain que précédement.
                //Déselection de l'élément précédent : remise en forme basique
                list_domains[selectedDomain_index].style.backgroundColor = "#fff";
                list_domains[selectedDomain_index].style.color = "#3F4254";
                //Sélection de l'objet passé en paramètre : mise en forme séléction.
                list_domains[object.id].style.backgroundColor = "#3699FF";
                list_domains[object.id].style.color = "#fff";

                selectedDomain_index = object.id;

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var res = this.response;
                        setSelectedClient(res["clientId"]);
                        var list_DNSRecord = res["list_DNSRecord"];
                        displayDNSLine(list_DNSRecord);

                    } else if (this.readyState == 4) {
                        alert("Une erreur est survenue..");
                    } else if (this.statusText == "parsererror") {
                        alert("Erreur Json");
                    }
                };

                xhr.open("POST", "module/domain/select/selectDomain_domaine.php", true);
                xhr.responseType = "json";
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("idDomain=" + encodeURI(object.getAttribute("name"))); //Name == id.
            } else if (selectedDomain_index === null) {
                //Déselection de l'élément précédent : remise en forme basique
                list_domains[0].style.backgroundColor = "#fff";
                list_domains[0].style.color = "#3F4254";
                //Sélection de l'objet passé en paramètre : mise en forme séléction.
                list_domains[object.id].style.backgroundColor = "#3699FF";
                list_domains[object.id].style.color = "#fff";

                selectedDomain_index = object.id;
            }
        }
    } else {
        if ((object.id != selectedDomain_index && selectedDomain_index != null) || forced) { //Evite de faire de l'ajax si il click sur le meme domain que précédement.
            //Déselection de l'élément précédent : remise en forme basique
            list_domains[selectedDomain_index].style.backgroundColor = "#fff";
            list_domains[selectedDomain_index].style.color = "#3F4254";
            //list_domains[selectedDomain_index].classList.remove("box_domaine-selected");
            //Sélection de l'objet passé en paramètre : mise en forme sélection.
            console.log(object.id);
            list_domains[object.id].style.backgroundColor = "#3699FF";
            list_domains[object.id].style.color = "#fff";
            //list_domains[object.id].classList.add("box_domaine-selected");

            selectedDomain_index = object.id;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = this.response;
                    setSelectedClient(res["clientId"]);
                    var list_DNSRecord = res["list_DNSRecord"];
                    displayDNSLine(list_DNSRecord);

                } else if (this.readyState == 4) {
                    alert("Une erreur est survenue..");
                } else if (this.statusText == "parsererror") {
                    alert("Erreur Json");
                }
            };

            xhr.open("POST", "module/domain/select/selectDomain_domaine.php", true);
            xhr.responseType = "json";
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("idDomain=" + encodeURI(object.getAttribute("name"))); //Name == id.
        } else if (selectedDomain_index === null) {
            //Déselection de l'élément précédent : remise en forme basique
            list_domains[0].style.backgroundColor = "#fff";
            list_domains[0].style.color = "#3F4254";
            //Sélection de l'objet passé en paramètre : mise en forme séléction.
            list_domains[object.id].style.backgroundColor = "#3699FF";
            list_domains[object.id].style.color = "#fff";

            selectedDomain_index = object.id;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = this.response;
                    setSelectedClient(res["clientId"]);

                } else if (this.readyState == 4) {
                    alert("Une erreur est survenue..");
                } else if (this.statusText == "parsererror") {
                    alert("Erreur Json");
                }
            };

            xhr.open("POST", "module/domain/select/selectDomain_domaine.php", true);
            xhr.responseType = "json";
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("idDomain=" + encodeURI(object.getAttribute("name"))); //Name == id.
        }
    }
}