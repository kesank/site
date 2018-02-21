<?php 
require_once('../inc/init.inc.php');

if(!userAdmin()){
	header('location:'.RACINE_SITE.'connexion.php');
} 


if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	
	//Si on a un ID dans l'URL, et que cet ID n'est pas vide, et que cet ID soit bien une valeur numérique alors on va pouvoir procéder à la suppression du produit...
	//...d'abord, on va vérifier que le produit existe.Car un petit malin pourrait avoir mis un chiffre au hasard dans l'URL.
	
	$resultat=$pdo->prepare("SELECT* FROM produit WHERE id_produit= :id" );
	$resultat->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
	$resultat->execute();
	
	//Comment savoir que le produit existe?
	if($resultat->rowCount()>0){//Cela signifie que le produit existe
		//Fetch pour récupérer un array
		$produit=$resultat->fetch();
		//DELETE...
		$resultat=$pdo->exec("DELETE FROM produit WHERE id_produit=$produit[id_produit]");
		//chemin de la photo à supprimer
		$photo_a_supprimer=$_SERVER['DOCUMENT_ROOT']. RACINE_SITE. 'photo/'.$produit['photo'];
		
		//Supprimer la photo du serveur...
		if($resultat !=0 && file_exists($photo_a_supprimer)){
			unlink($photo_a_supprimer);
			
			//On redirige vers la page:
			header('location:gestion_boutique.php');
		}
	}
	else{
		header('location:gestion_boutique.php');
	}
}

else{
		header('location:gestion_boutique.php');
	}
?>