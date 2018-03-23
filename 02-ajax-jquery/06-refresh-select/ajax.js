$(function(){

    setInterval( ajax, 5000);
    ajax();

    $("#submit").on('click', function(event){
        event.preventDefault();
        ajaxEnvoiForm();
    })

    function ajax(){

        $.post("ajax.php", "", function(donnees){
            if(donnees.validation == 'ok'){
                $("#resultat").html(donnees.resultat);
            } else {
                alert('PBHJEKIbgzheiao');
            }
        }, 'json');
    }

    function ajaxEnvoiForm(){
        var personne = $('#personne').val();
        $.post("ajax.php","personne="+personne+"$mode=envoi", function(donnees){

        },'json');
    }
})