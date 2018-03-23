document.addEventListener("DOMContentLoaded", function(event){

    document.getElementById('submit').addEventListener('click',
        function(event){
            event.preventDefault(); // annule le comportement par défaut du submit
            ajax();
        });


    function ajax(){

        if ( window.XMLHttpRequest ) r = new XMLHttpRequest(); // Pour la plupart des navigateurs
        else r = new ActiveXObject("Microsoft.XMLHTTP"); // Pour les connards qui utilisent IE
        var p = document.getElementById("personne");
        var personne = p.value;

        var parametres = "personne="+personne;
        r.open("POST","ajax.php", true);
        r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        r.send(parametres);

        document.getElementById('resultat').innerHTML="<div class=\"divresul\">employé "+personne+" ajouté !</div>";
        document.getElementById('personne').value="";

    }
});