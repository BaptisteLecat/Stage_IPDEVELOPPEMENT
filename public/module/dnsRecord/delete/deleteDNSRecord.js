function deleteDNSLine(object) {
    var row = object.parentElement.parentNode; // == TR (ligne)

    if (confirm("La suppression d'un DNS est définitive.\n\nEtes-vous sur de vouloir supprimer ce DNS?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.response;
                row.remove();

            } else if (this.readyState == 4) {
                alert("Une erreur est survenue..");
            } else if (this.statusText == "parsererror") {
                alert("Erreur Json");
            }
        };

        xhr.open("POST", "module/dnsRecord/delete/deleteDNSRecord.php", true);
        xhr.responseType = "json";
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("idDNSRecord=" + encodeURI(row.getAttribute("name"))); //Name == id.
    }
}