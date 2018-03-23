<?php

// ouverture de la connexion BDD
$pdo = new PDO('mysql:host=localhost;dbname=tchat',
'root',
'',
array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

// ouverture de session
session_start();

// Initialisation variable
$msg = '';

// Fonction de calcul d'age à partir d'une date de naissance sous la forme AAAA-MM-JJ
function age($naiss)
{
    list($y, $m, $d ) = explode('-',$naiss);
    $diff = date('m') - $m ;
    if ( $diff < 0)
    {
        $y++;
    }
    elseif ( $diff == 0 && ( date('d') - $d < 0) )
    {
        $y++;
    }
    return date('Y') - $y;
}