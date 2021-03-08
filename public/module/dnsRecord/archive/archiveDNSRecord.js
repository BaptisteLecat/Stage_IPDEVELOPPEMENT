function archiveDNSLine(object) {
    var row = object.parentElement.parentNode; // == TR (ligne)

    if (confirm("L'archivage d'un DNS entraine une sauvegarde de 7 jours.\n\nEtes-vous sur de vouloir archiver ce DNS?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.response;
                for (let index = 1; index < 4; index++) {
                    row.getElementsByTagName("td")[index].classList.add("archived");
                }
                row.getElementsByTagName("td")[4].style.color = "#e85a4e";
                row.getElementsByTagName("td")[4].innerText = `${res["timeBeforeDeleted"] - 1}j`;

                var buttons = row.getElementsByTagName("button");
                buttons[0].title = "Restaurer";
                buttons[0].innerText = "Restaurer";
                buttons[0].setAttribute("onclick", "restoreDNSLine(this);");

                buttons[1].title = "Supprimer";
                buttons[1].innerText = "Supprimer";
                buttons[1].setAttribute("onclick", "deleteDNSLine(this);");

            } else if (this.readyState == 4) {
                alert("Une erreur est survenue..");
            } else if (this.statusText == "parsererror") {
                alert("Erreur Json");
            }
        };

        xhr.open("POST", "module/dnsRecord/archive/archiveDNSRecord.php", true);
        xhr.responseType = "json";
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("idDNSRecord=" + encodeURI(row.getAttribute("name"))); //Name == id.
    }
}