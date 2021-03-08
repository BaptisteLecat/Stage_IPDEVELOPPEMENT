function changeCheckState(object) {
    var checkState = 0;
    var idDomain = object.parentElement.parentNode.parentNode.getAttribute("name"); // boxDomaine
    if (object.checked) {
        checkState = 1;
    } else {
        checkState = 0;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            if (checkState == true) {
                object.checked = true;
            } else {
                object.checked = false;
            }

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/domain/manageDNS/manageDNS.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idDomain=" + encodeURI(idDomain) + "&checkState=" + encodeURI(checkState));
}