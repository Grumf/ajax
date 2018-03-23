$(document).ready(function(){


    var personne = $('#personne').text();

    $.post("ajax.php", "personne="+personne, function(donnees){

        if( donnees.validation == 'ok' ){

            $("#resultat").html(donnees.resultat);
        } else {
            alert('pb affichage -_-');
        }

    }, 'json');

});