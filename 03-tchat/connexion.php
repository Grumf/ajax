<?php

require_once('inc/init.php');

// Traitement du formulaire en POST
if ( isset($_POST['connexion']) ){ // Si on clique sur connexion

    $resultat = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $resultat->execute(array('pseudo' => $_POST['pseudo']) );
    $membre = $resultat->fetch(PDO::FETCH_ASSOC);

    if ( $resultat->rowCount() == 0 ){
        // Insertion en base d'un nouveau membre
        $result = $pdo->prepare("INSERT INTO membre VALUES (NULL, :pseudo, :civilite, :ville, :date_de_naissance, :ip,".time().")");
        $result->execute(array(
            "pseudo" => $_POST['pseudo'],
            "civilite" => $_POST['civilite'],
            "ville" => $_POST['ville'],
            "date_de_naissance" => $_POST['date_de_naissance'],
            "ip" => gethostbyname( $_SERVER['REMOTE_NAME'])
        ));

        $id_membre = $pdo->lastInsertId();

    } elseif ( $resultat->rowCount()>0 && $membre['ip'] == gethostbyname( $_SERVER['REMOTE_NAME']) ){ // <=== Recupère l'ip de la personne connectée
        /* Le pseudo est connu et l'internaute est propriétaire du pseudo (meme ip)
            On met à jour la base de connexion */
            $result = $pdo->prepare("UPDATE membre SET date_connexion=".time()." WHERE id_membre=:id_mmebre");
            $result->execute( array("id_membre"=> $membre['id_membre']));
            $id_membre = $membre['id_membre'];

    } else {
        $msg.='<div class="erreur">Ce pseudo est déjà réservé</div>';
    }

    if (empty($msg)){

        // remplir $_SESSION et deririger vers index.php
        $_SESSION['id_membre'] = $id_membre;
        $_SESSION['pseudo'] = $_POST['pseudo'];
        header("location:index.php");
        exit();
    }

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link rel="stylesheet" href="inc/style.css">
</head>
<body>
    <?= $msg ?>
    <fieldset>
        <form method="post" action="">

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" value="" required><br>

            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" value=""><br>

            <label for="civilite">Titre</label><br>
            <input type="radio" id="civilite" name="civilite" value="f" checked> Femme
            <input type="radio" id="civilite" name="civilite" value="m"> Homme<br>

            <label for="date_de_naissance">Date de naissance (YYYY-MM-DD)</label>
            <input type="text" id="date_de_naissance" name="date_de_naissance" value=""><br>

            <input type="submit" name="connexion" value="Connexion au Tchat !">

        </form>
    </fieldset>
</body>
</html>