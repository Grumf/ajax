<?php

require_once('init.php');

$result = $pdo->query("SELECT * FROM employes ORDER BY RAND()");
$employe = $result->fetch(PDO::FETCH_ASSOC);

$tab = array();
$tab['resultat'] = $employe['prenom'].' '.$employe['nom'];

echo json_encode($tab);