<?php

require_once('init.php');

extract($_POST);


$result = $pdo->prepare("INSERT INTO employes (prenom) VALUES (:personne)");
if ( $result->execute(array( 'personne' => $personne )) ){

    $tab['validation'] = 'ok';
    echo json_encode($tab); // { 'validation' : 'ok' }
}