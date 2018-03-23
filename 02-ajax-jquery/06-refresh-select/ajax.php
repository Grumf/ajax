<?php

require_once('init.php');
extract($_POST);

if ( isset($mode) && $mode == 'envoi'){
    $result = $pdo->prepare("INSERT INTO employes (prenom) VALUES (:personne)");
    if ( $result->execute( array('personne'=>$personne)) ){
        $tab['validation']= 'ok';
    }
}
 
$tab = array();
$tab['resultat'] = '';

$result = $pdo->prepare("SELECT * FROM employes ORDER BY nom");
$result->execute();

$tab['resultat'].='<table border="5"><tr>';
$nbcolonnes = $result->columnCount();
for( $i=0; $i < $nbcolonnes; $i++){
    $infocolonne = $result->getColumnMeta($i);
    $tab['resultat'].='<th>'.$infocolonne['name'].'</th>';
}
$tab['resultat'].="</tr>";

while ( $ligne = $result->fetch(PDO::FETCH_ASSOC) )
{
    $tab['resultat'].="<tr>";
        foreach ( $ligne as $information ){
            $tab['resultat'].="<td>$information</td>";
        }
    $tab['resultat'].="</tr>";
}
$tab['resultat'].="</table>";
$tab['validation'] ="ok";

echo json_encode($tab);