$(document).ready(function(){


    $('#submit').click(function(event){

        event.preventDefault();
        ajax();
    });

    function ajax(){

        personne = $('#personne').val();

        // $.post("fichier destination", "paramètres", function("reponse"){}, "format");
        /* $.post("fichier.txt",'',function(data){
            $("#demo").html(data);
        }),"text"); */

        $.post("ajax.php","personne="+personne, function(donnees){
            if( donnees.validation == 'ok' ){

                $("#resultat").append("<div class='diresul'>employé "+personne+" ajouté</div>");
                $("#personne").val("");
            } else {

                alert("t'es moche.");
            }
        }, "json");
    }
});