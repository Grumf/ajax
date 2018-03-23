document.addEventListener("DOMContentLoaded", function(event){

    document.getElementById('submit').addEventListener('click', function(event){

        event.preventDefault();
        ajax();
    });

    function ajax(){

        if ( window.XMLHttpRequest ) r = new XMLHttpRequest(); // Pour la plupart des navigateurs
        else r = new ActiveXObject("Microsoft.XMLHTTP"); // Pour les connards qui utilisent IE
        var p = document.getElementById("personne");
        var id = p.options[p.selectedIndex].value;
        var parametres = "id="+id;

        r.open('POST','ajax.php', true);
        r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        r.onreadystatechange = function(){

            if ( r.readyState == 4 && r.status == 200){

                var obj = JSON.parse(r.responseText);
                document.getElementById('employes').innerHTML = obj.resultat;
            }
        }
        r.send(parametres); 
    }
});