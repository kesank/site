<?php

//Session
session_start();

//Connexion BDD
$pdo= new PDO('mysql:host=localhost;dbname=site', 'root', '', array(
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,
	PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES utf8',
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
));

//Variables
$msg='';
$page='';
$contenu='';
//Chemins
define('RACINE_SITE', '/PHP/site/');
//le chemin à partir de htdocs

//Autres inclusions

require_once('fonctions.inc.php');
