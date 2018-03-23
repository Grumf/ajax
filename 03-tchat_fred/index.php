<?php

require_once('inc/init.php');

if ( !isset($_SESSION['pseudo']) ) // si on a pas de pseudo enregistré en session, c'est que je ne suis pas passé par la page connexion
{
    header('location:connexion.php'); // redirection vers connexion
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tchat</title>
    <link rel="stylesheet" href="inc/style.css">
</head>
<body>
<script>
    <?php 
    $result = $pdo->query("SELECT id_dialogue FROM dialogue ORDER BY id_dialogue DESC LIMIT 0,1");
    $donnees = $result->fetch(PDO::FETCH_ASSOC);
    ?>
    var lastid = <?= $donnees['id_dialogue'] ?? 0 ?>;
</script>
<div id="conteneur">
    <div id="message_tchat">
    <?php
    echo '<h2>connecté en tant que '.$_SESSION['pseudo'].'</h2>';

    $result = $pdo->query("SELECT 
    d.id_dialogue,m.pseudo,m.civilite,d.message,
    DATE_FORMAT(d.date,'%d/%m/%Y') as datefr,
    DATE_FORMAT(d.date, '%H:%i:%s') as heurefr
    FROM dialogue d, membre m
    WHERE m.id_membre = d.id_membre 
    ORDER BY d.date");
    while ( $dialogue = $result->fetch(PDO::FETCH_ASSOC ))
    {
        if ($dialogue['civilite'] == 'm' ) { $couleur="bleu";}else{$couleur="rose";}

        echo '<p title="'.$dialogue['datefr'].'-'.$dialogue['heurefr'].'" class="'.$couleur.'"><strong>'.$dialogue['pseudo'].'</strong> > '.htmlspecialchars($dialogue['message']).'</p>';

    }
    ?>
    </div>
    <div id="liste_membre_connecte">
        <h2>Membres connectés:</h2>
        <?php
        $resultat=$pdo->query("SELECT * FROM membre WHERE date_connexion >".(time()-1800)." ORDER BY pseudo");
        while ( $membre = $resultat->fetch(PDO::FETCH_ASSOC))
        {
            if ( $membre['civilite'] == 'm' )
            {
                $couleur='bleu';
                $titre="Homme";
            }
            else{
                $couleur='rose';
                $titre="Femme";
            }
            echo '<p class="'.$couleur.'" 
            title="'.$titre.', '.$membre['ville'].', '.age($membre['date_de_naissance']).' ans">'.$membre['pseudo'].'</p>';
        }
        ?>
    </div>
    <div class="clear"></div>
    <div id="smiley">
        <img class="smiley" src="smil/smiley1.gif" alt=":)">
        <img class="smiley" src="smil/smiley2.gif" alt=":|">
        <img class="smiley" src="smil/smiley3.gif" alt=":d">
        <img class="smiley" src="smil/smiley4.gif" alt=":p">
        <img class="smiley" src="smil/smiley5.gif" alt="{3">
        <img class="smiley" src="smil/smiley6.gif" alt=":o">
    </div>
    <div id="formulaire_tchat">
            <form method="post" action="#">
                <textarea id="message" name="message" rows="4" maxlength="300"></textarea><br>
                <input type="submit" name="envoi" value="Envoi" class="submit" id="submit">
            </form>
    </div>
</div>
    

    <script src="inc/jquery-3.3.1.min.js"></script>
    <script src="inc/ajax.js"></script>
</body>
</html>