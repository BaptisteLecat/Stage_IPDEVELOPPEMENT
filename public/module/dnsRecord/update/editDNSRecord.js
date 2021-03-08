function editDNSLine(object) {
    var row = object.parentElement.parentNode; // == TR (ligne)
    var columns = row.getElementsByTagName("td"); // == collection de TD (colonne)

    if (editedDNS_index != null) {
        alert("Veuillez terminer la modification en cours!");
    } else {
        // On sauvegarde les données de base, pour les restaurer en cas d'annulation de la modification.
        arrayDNS_info = {
            "host": columns[1].innerText,
            "type": columns[2].innerText,
            "value": columns[3].innerText,
        };

        var xhr = new XMLHttpRequest();
        var list_DNSField = new Array();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.response;
                list_DNSField = res["list_DNSField"];
                displayEditLine(list_DNSField, columns);

                //SET le nouveau editedDNS.
                editedDNS_index = row.id;

                //Affiche Buttons.
                document.getElementById("btn-validate").style.display = "block";
                document.getElementById("btn-cancel").style.display = "block";

            } else if (this.readyState == 4) {
                alert("Une erreur est survenue..");
            } else if (this.statusText == "parsererror") {
                alert("Erreur Json");
            }
        };

        xhr.open("POST", "module/dnsRecord/loadDNSField.php", true);
        xhr.responseType = "json";
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send();
    }
}

function cancelEditDNS() {
    var edited_row = document.getElementsByTagName("tbody")[0].getElementsByTagName("tr")[editedDNS_index];
    var edited_columns = edited_row.getElementsByTagName("td");

    edited_columns[1].innerHTML = `${arrayDNS_info["host"]}`;
    edited_columns[2].innerHTML = `${arrayDNS_info["type"]}`;
    edited_columns[3].innerHTML = `${arrayDNS_info["value"]}`;

    editedDNS_index = null;
    document.getElementById("btn-validate").style.display = "none";
    document.getElementById("btn-cancel").style.display = "none";
}

function validateEditDNS() {
    var edited_row = document.getElementsByTagName("tbody")[0].getElementsByTagName("tr")[editedDNS_index];
    var edited_columns = edited_row.getElementsByTagName("td");
    arrayDNS_input = {
        "host": edited_columns[1].getElementsByTagName("input")[0].value,
        "idType": edited_columns[2].getElementsByTagName("select")[0].selectedOptions[0].value,
        "type": edited_columns[2].getElementsByTagName("select")[0].selectedOptions[0].innerText, // Id du type.
        "value": edited_columns[3].getElementsByTagName("input")[0].value,
    };

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            edited_columns[1].innerHTML = `${arrayDNS_input["host"]}`;
            edited_columns[2].innerHTML = `${arrayDNS_input["type"]}`;
            edited_columns[3].innerHTML = `${arrayDNS_input["value"]}`;

            editedDNS_index = null;
            document.getElementById("btn-validate").style.display = "none";
            document.getElementById("btn-cancel").style.display = "none";

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/dnsRecord/update/updateDNSRecord.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idDNSRecord=" + encodeURI(edited_row.getAttribute("name")) + "&arrayDNSInfo=" + JSON.stringify(arrayDNS_input)); //Name == id.
}