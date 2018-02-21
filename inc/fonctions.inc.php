<?php

//Une fonction debug, pour faire des print_r

function debug($tab){
	echo '<div style="color: white; padding:20px; background:#' .rand(111111,999999) .'">';
	$trace= debug_backtrace();//Cette fonction est pratique car nous retrouvons plein d'informations depuis lequel la fonction en cours a été exécuté!! Tableau multidimensionnel.
	echo 'Le debug a été demandé dans le fichier:' .$trace[0]['file']. 'à la ligne:' .$trace[0]['line'].'<hr/>';
	
	echo '<pre>';
	print_r($tab);
	echo '</pre>';
	
	
	
	
	echo '</div>';

	
}
//Fonctions pour voir si l'utilisateur est connecté ou non
function userConnecte(){
	if(isset($_SESSION['membre'])){
		return true;
	}
	else{
		return false;
	}
	
}
//focntions pour voir si l'utilisateur est admin ou pas
function userAdmin(){
	if(userConnecte() && $_SESSION['membre']['statut']==1){
		return true;
	}
	else{
		return false;
	}
}	
	
	
	
	





