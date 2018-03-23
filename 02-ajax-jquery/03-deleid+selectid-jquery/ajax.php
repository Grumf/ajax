<?php

require_once('init.php');
extract($_POST);

$result = $pdo->prepare("DELETE FROM employes WHERE id_employes= :id");
$result->execute(array('id' => $id));

// Je régénère la liste de prénoms
$tab = array();
$tab['resultat']='';

$result = $pdo->query("SELECT * FROM employes");
$tab['resultat'].='<select name="personne" id="personne">';

while( $employe = $result->fetch(PDO::FETCH_ASSOC) ){

    $tab['resultat'].= '<option value="'.$employe['id_employes'].'">'.$employe['prenom'].'</option>';
}

$tab['resultat'].= '</select>';
$tab['validation'] = 'ok';

echo json_encode($tab);