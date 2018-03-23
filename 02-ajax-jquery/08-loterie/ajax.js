$(function(){

    $('#tirage').on('click', function(){
        ajax();
    });

    function ajax(){

        $.post('ajax.php','', function(retour){
            $("#resultat").html(retour.resultat);
        }, 'json');
    }
});