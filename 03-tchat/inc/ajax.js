$(function(){
// var lastid = 0;
        var timer = setInterval(affichage_message, 5000);
        var timer_membre_connecte = setInterval(affichage_membre_connecte, 10000);
        $("#message_tchat").scrollTop($("#message_tchat")[0].scrollHeight); // Met l'ascenceur tout en bas pour rendre visible le dernier message
        convertir_smiley();

    function affichage_membre_connecte(){
    $.post('inc/ajax.php','action=affichage_membre_connecte', function(donnees){
        if ( donnees.validation == 'ok' ){
            $("#liste_membre_connecte").empty().append(donnees.resultat);
        }
    }, 'json');

    }

    function convertir_smiley(){

        $("#message_tchat p").each(function(){
            $("#message_tchat").html( $("#message_tchat").html().replace(':)','<img src="smil/smiley1.gif">'));
            $("#message_tchat").html( $("#message_tchat").html().replace(':|','<img src="smil/smiley2.gif">'));
            $("#message_tchat").html( $("#message_tchat").html().replace(':d','<img src="smil/smiley3.gif">'));
            $("#message_tchat").html( $("#message_tchat").html().replace(':p','<img src="smil/smiley4.gif">'));
            $("#message_tchat").html( $("#message_tchat").html().replace('{3','<img src="smil/smiley5.gif">'));
            $("#message_tchat").html( $("#message_tchat").html().replace(':o','<img src="smil/smiley6.gif">'));
        })
    }

    function affichage_message(){

        showLoader('#message_tchat');
        
        $.post('inc/ajax.php','action=affichage_message&lastid='+lastid, function(donnees){
        $("#message_tchat").append(donnees.resultat);
        lastid = donnees.lastid;
        $("#message_tchat").scrollTop($("#message_tchat")[0].scrollHeight);
        convertir_smiley();
        }, 'json');

    }

    

    $("#submit").on('click', function(event){
        event.preventDefault();
        showLoader("#formulaire_tchat");
        clearInterval(timer);
        var message = $('#message').val();
        var parameters = 'message='+message+'&action=envoi_message';
        $.post('inc/ajax.php', parameters, function(donnees){
            if ( donnees.validation == 'ok' ){
                affichage_message();
                $("#message").val('');
                $("#message").focus();
            } else {
                alert('pb wesh');
            }
            timer = setInterval(affichage_message, 5000);
            hideLoader();
        }, 'json');
    })

    // insertion du smiley au clic
    $(".smiley").on('click', function(event){
        var prevMsg = $("#message").val();
        var emotiText = $(event.target).attr("alt");
        $("#message").val(prevMsg + emotiText);
    });

    function showLoader(div){
        $(div).append('<div class="loader"></div>');
        $('.loader').fadeTo(500,0.6);
    }

    function hideLoader(){
        $('.loader').fadeOut(500, function(){
           $('.loader').remove(); 
        });
        
    }

}); // Fin du ready.function