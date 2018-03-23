<?php

require_once('init.php');

extract($_POST);

$tab = array();

if( $action == 'envoi_message' ){
    $message = htmlspecialchars($message);

    if ( !empty($message) ){
        $result = $pdo->prepare("INSERT INTO dialogue VALUES (NULL, :id_membre, :message, NOW())");
        $result->execute(array(
            'id_membre' => $_SESSION['id_membre'],
            'message' => $message
        ));
        // Mise à jour de la timestamp de l'activité
        $result = $pdo->prepare("UPDATE membre SET date_connexion=".time()." WHERE id_membre=:id_membre");
        $result->execute(array('id_membre' => $_SESSION['id_membre']));
    }

    $tab['validation'] = 'ok';
}

if ( $action == 'affichage_message' ){

    $lastid = floor($lastid); // Methode de forcage au type INTeger
    $result = $pdo->prepare("SELECT d.id_dialogue, m.pseudo, m.civilite, d.message, date_format(d.date, '%d/%m/%Y') AS datefr, date_format(d.date, '%H/%i/%s') AS heurefr FROM dialogue d, membre m WHERE m.id_membre = d.id_membre AND d.id_dialogue > :lastid ORDER BY d.date");
    $result->execute(array('lastid' => $lastid ));

    $tab['resultat']='';
    $tab['lastid'] = $lastid;

    while ( $dialogue = $result->fetch(PDO::FETCH_ASSOC) ){
        if( $dialogue['civilite'] == 'm' ) { $couleur = 'bleu'; }
        else { $couleur = 'rose'; }

        $tab['resultat'] .=  '<p title="'.$dialogue['datefr'].'-'.$dialogue['heurefr'].'" class="'.$couleur.'"><strong>'.htmlspecialchars($dialogue['pseudo']).'</strong> > '.htmlspecialchars($dialogue['message']).'</p>';

        $tab['lastid'] = $dialogue['id_dialogue'];
    }

    $tab['validation'] = 'ok'; 
}

if ( $action == 'affichage_membre_connecte' ){
    $resultat = $pdo->query("SELECT * FROM membre WHERE date_connexion >".(time()-1800)." ORDER BY pseudo");
    $tab['resultat'] = '<h2>membres connectés:</h2>';
                while( $membre = $resultat->fetch(PDO::FETCH_ASSOC) ){
                    if ( $membre['civilite'] == 'm' ){
                        $couleur='bleu';
                        $titre='Homme';
                    } else {
                        $couleur='rose';
                        $titre='Femme';
                    }
                    $tab['resultat'] .= '<p class="'.$couleur.'" 
                    title="'.$titre.', '.$membre['ville'].', '.age($membre['date_de_naissance']).' ans">'.$membre['pseudo'].'</p>';
                }
                $tab['validation'] = 'ok';
}

echo json_encode($tab);