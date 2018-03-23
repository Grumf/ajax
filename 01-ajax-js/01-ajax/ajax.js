// AJAX
// Asynchronous Javascript And Xml (Json serait plus approprié)

document.getElementById("action").addEventListener("click",loadDoc);

function loadDoc(){

    var xhttp = new XMLHttpRequest();
    // readyState , doit être égal à 4 pour confirmer qu'il a abouti
    // status ,  doit être égal à 200 pour confirmer le chargement réussi du fichier
    xhttp.onreadystatechange = function() {

        if ( xhttp.readyState == 4 && xhttp.status == 200 ) {

            document.getElementById("demo").innerHTML = xhttp.responseText;
        }
    }

    xhttp.open("GET","fichier.txt", true);
    xhttp.send();
}