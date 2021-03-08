function restoreDNSLine(object) {
    var row = object.parentElement.parentNode; // == TR (ligne)

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            for (let index = 0; index < 4; index++) {
                row.getElementsByTagName("td")[index].classList.remove("archived");
            }
            row.getElementsByTagName("td")[4].style.color = null;
            row.getElementsByTagName("td")[4].innerText = `---`;

            var buttons = row.getElementsByTagName("button");
            buttons[0].title = "Editer";
            buttons[0].innerText = "Editer";
            buttons[0].setAttribute("onclick", "editDNSLine(this)");

            buttons[1].title = "Archiver";
            buttons[1].innerText = "Archiver";
            buttons[1].setAttribute("onclick", "archiveDNSLine(this)");

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/dnsRecord/restore/restoreDNSRecord.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idDNSRecord=" + encodeURI(row.getAttribute("name"))); //Name == id.
}