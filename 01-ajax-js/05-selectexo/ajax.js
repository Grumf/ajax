document.addEventListener("DOMContentLoaded", function(event){

    document.getElementById('submit').addEventListener('click', function(event){

        event.preventDefault();
        ajax();
    });

    function ajax(){

    if ( window.XMLHttpRequest ) r = new XMLHttpRequest();
    else r = new ActiveXObject("Microsoft.XMLHTTP");

    var personne = document.getElementById('personne');
    personne = personne.options[personne.selectedIndex].value;
    var parametres = "personne="+personne;

    r.open('POST','ajax.php', true);
        r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        r.onreadystatechange = function(){

            if ( r.readyState == 4 && r.status == 200){

                var obj = JSON.parse(r.responseText);
                document.getElementById('resultat').innerHTML = obj.resultat;
            }
        }
        r.send(parametres);
    }
})