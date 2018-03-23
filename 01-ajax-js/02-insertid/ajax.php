<?php

require_once('init.php');

extract($_POST);

/*
'personne' => 'Francis'

extract va créer $personne = 'Francis';

*/

echo $personne;

$result = $pdo->prepare("INSERT INTO employes (prenom) VALUES (:personne)");
$result->execute(array( 'personne' => $personne ));