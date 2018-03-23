$(document).ready(function(){

    $("#submit").click(function(event){
        event.preventDefault();
        ajax();
    });

    function ajax(){
        var id = $("#personne").find(":selected").val();

        $.post("ajax.php", "id="+id, function(donnees){
            if (donnees.validation== 'ok'){
                $("#employes").html(donnees.resultat);
            } else {
                alert('Problème liste employés');
            }
        }, 'json');
    }
})