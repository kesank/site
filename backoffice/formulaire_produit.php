<?php


require_once('../inc/init.inc.php');
//REDIRECTION si user n'est pas admin
if(!userAdmin()){
	header('location:'.RACINE_SITE.'connexion.php');
} 


debug($_POST);
debug($_FILES);//Superglobales qui nous permet d'accéder à toutes les infos d'un fichier uploadé (grace à l'attribut enctype)


if($_POST){
	//On verifie si ya une photo avant de faire une opération dessus:
	//Si on modifie un produit, il existe déja une photo pour ce produit
	
	if(!empty($_FILES['photo']['name'])){//Si le nom de la photo n'est pas vide c'est qu'il y a bien une photo postée.
		//1: On modifie le nom de la photo pour éviter que 2 personnes puisse uploader 2 photos du meme et donc que la seconde écrase la première:
		//$nom_photo:
		$nom_photo=$_POST['reference']. '_'. time(). '_'.rand(1,999).'_'. $_FILES['photo']['name'];
		echo $nom_photo;
		//On a crée un nom de photo composé de : ref produit puis timestamp actuel puis nom original de la photo...
		
		$chemin_photo= $_SERVER['DOCUMENT_ROOT']. RACINE_SITE. 'photo/' .$nom_photo;
		//echo $chemin_photo;
		//Emplacement définitif de notre image
		//Vérifier l'extension de la photo
		$ext= array('image/png', 'image/jpeg','image/gif');
		if(!in_array($_FILES['photo']['type'], $ext)){//Si le type du fichier uploadé ne corresponds pas au extentions autorisées, que l'on a stockées dans l'array $ext... alors:
			$msg .= '<div class="erreur">Veuillez choisir un fichier de type PNG,JPEG,JPG ou GIF.</div>';
		//Vérifier la taille de l'image (en octects)	
		if($_FILES['photo']['size']>2500000){//supérieur à 2,5Mo
			$msg .='<div class="erreur">taille maximum des fichiers: 2,5</div>';
		
		}
		//Il nous reste à enregistrer le fichier image (copier/coller depuis son emplacement temporaire vers son emplacement définitif)...mais avant de le faire, nous allons nous assurer que l'enregistrement du produit est bien OK. Cela ne sert à rien d'enregistrer une image requete pour enregistrer le produit n'est pas OK.
		}
	}
	
	
	
	
	
	
	
	elseif(isset($_POST['photo_actuelle'])){//notre input caché
		$nom_photo=$_POST['photo_actuelle'];
		//Donc on prend le nom de la photo actuelle qu'on mets dans $nom_photo afin qu'elle soit enregistrée dans sa requete.
	}
	
	
	
	else{
		$msg .='<div class="erreur">Veuillez choisir une photo pour le produit.</div>';
	}
	
	
	//Tout est OK, on peut donc penser à enregistrer les infos en BDD.. et aussi enregistrer l'image:
	if(empty($msg)){//$MSG est vide? Cela signifie que nous sommes passé dans aucun message erreur.
		if(!empty($_POST['id_produit'])){//je suis en train de modifier un produit
		$resultat=$pdo->prepare("REPLACE INTO produit(id_produit,reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES(:id_produit,:reference, :categorie, :titre, :description,:couleur, :taille, :public, :photo, :prix, :stock ) ");	
		

		$resultat->bindparam(':id_produit',$_POST['id_produit'],PDO::PARAM_INT);
		}
		
		else{//je suis en train d'ajouter un produit
		$resultat=$pdo->prepare("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES(:reference, :categorie, :titre, :description,:couleur, :taille, :public, :photo, :prix, :stock ) ");
		
		
		}
		$resultat->bindParam(':reference',$_POST['reference'],PDO::PARAM_STR);
		$resultat->bindParam(':categorie',$_POST['categorie'],PDO::PARAM_STR);
		$resultat->bindParam(':titre',$_POST['titre'],PDO::PARAM_STR);
		$resultat->bindParam(':couleur',$_POST['couleur'],PDO::PARAM_STR);
		$resultat->bindParam(':taille',$_POST['taille'],PDO::PARAM_STR);
		$resultat->bindParam(':public',$_POST['public'],PDO::PARAM_STR);
		$resultat->bindParam(':photo',$nom_photo ,PDO::PARAM_STR);
		$resultat->bindParam(':prix',$_POST['prix'],PDO::PARAM_STR);
		$resultat->bindParam(':description',$_POST['description'],PDO::PARAM_STR);
		
		//INT
		$resultat->bindParam(':stock',$_POST['stock'],PDO::PARAM_INT);
		if($resultat->execute()){//Si la requete s'est bien passée
			if(!empty($_FILES['photo']['name'])){
		//1: On enregistre l'image
		copy($_FILES['photo']['tmp_name'],$chemin_photo);}
		//On copie/colle la photo depuis son emplacement temporaire ($_FILES['photo']['tmp_name'])vers son emplacement définitif représenté la variable $chemin_photo.
		
		//2: Redirige vers gestion boutique
		header('location:gestion_boutique.php');
			
		}//fin du if($resultat->execute() )
			
	}//Fin du if (empty($msg) )
	
}//Fin du if($_POST)
//verifier s'il y a un id dans l'url...que cet id soit bien rempli, numérique et corresponde bien à un produit...
//-->Récupérer les infos du produit à modifier
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
 	// Si on a un id qui n'est pas vide et qui est numérique on va vérifier que le produit existe bien
 	$resultat=$pdo-> prepare("SELECT *FROM produit WHERE id_produit= :id");
	$resultat->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
 	$resultat->execute();

 	if ($resultat->rowCount()>0) {
 		//le produit existe bien

 		$produit_a_modifier=$resultat->fetch();
 		debug($produit_a_modifier);
 	}

 }

 //simplifier les variables


 if (!empty($_POST)) {
 	$reference=$_POST['reference'];
 	$categorie=$_POST['categorie'];
 	$titre=$_POST['titre'];
 	$description=$_POST['description'];
 	$couleur=$_POST['couleur'];
 	$taille=$_POST['taille'];
 	$public=$_POST['public'];
 	$photo=(!empty($_POST['photo']))? $_POST['photo']:'';
 	$prix=$_POST['prix'];
 	$stock=$_POST['stock'];
 }
 else{
 	$reference=(isset($produit_a_modifier)) ? $produit_a_modifier['reference'] : '';
 	$categorie=(isset($produit_a_modifier)) ? $produit_a_modifier['categorie'] : '';
 	$titre=(isset($produit_a_modifier)) ? $produit_a_modifier['titre'] : '';
 	$description=(isset($produit_a_modifier)) ? $produit_a_modifier['description'] : '';
 	$couleur=(isset($produit_a_modifier)) ? $produit_a_modifier['couleur'] : '';
 	$taille=(isset($produit_a_modifier)) ? $produit_a_modifier['taille'] : '';
 	$public=(isset($produit_a_modifier)) ? $produit_a_modifier['public'] : '';
 	$photo=(isset($produit_a_modifier)) ? $produit_a_modifier['photo'] : '';
 	$prix=(isset($produit_a_modifier)) ? $produit_a_modifier['prix'] : '';
 	$stock=(isset($produit_a_modifier)) ? $produit_a_modifier['stock'] : '';

 }

 


$action=(isset($produit_a_modifier)) ? 'Modifier' : 'Ajouter';
$id_produit= (isset($produit_a_modifier)) ? $produit_a_modifier['id_produit'] : '';

$page='Formulaire Produit';

require_once('../inc/haut.inc.php'); 
require_once('../inc/header.inc.php'); 
?>


<form method="post" action="" enctype="multipart/form-data">
<!--L'attribut enctype="multipart/fotm-data" permet de récupérer les fichiers uploadés -->
	<input type="hidden" name="id_produit" value="<?=$id_produit?>"/>
	
	<label >Reference</label><br/>
	<input type="text"  name="reference" value= "<?= $reference ?>" /><br/><br/>
	
	<label >Categorie</label><br/>
	<input type="text"  name="categorie" value= "<?= $categorie ?>" /><br/><br/>


	<label>Titre:</label><br/>
	<input type="text" name="titre" value="<?= $titre ?>" /><br/><br/>
	
	
	<label>Description:</label><br/>
	<textarea style="resize:none" name="description" rows="8" cols="20"><?= $description ?></textarea><br/><br/>
		
	<label >couleur</label><br/>
	<input type="text"  name="couleur" value="<?= $couleur ?>"/><br/><br/>
	<label>Taille</label><br/>
	<select name="taille"  ><br/>
		<option <?= ($taille=='xs') ? 'selected' :''?> value="xs" >XS</option>
		<option <?= ($taille=='s') ? 'selected' :''?> value="s" >S</option>
		<option <?= ($taille=='m') ? 'selected' :''?> value="m" >M</option>
		<option <?= ($taille=='l') ? 'selected' :''?> value="l" >L</option>
		<option <?= ($taille=='xl') ? 'selected' :''?> value="xl" >XL</option>
	</select><br/>
	
	<label>Prix</label><br/>
	<input type="text" name="prix"  value="<?= $prix ?>"/><br/><br/>
	
	<label>Stock</label><br/>
	<input type="text" name="stock"  value="<?= $stock ?>"/><br/><br/>
	

	
	
	 
	
	
	<label>Public</label><br/>
	<select name="public" value="<?=$public?>"><br/>
		<option <?= ($taille=="f") ? 'selected' :''?> value="f" name="femme">Femme</option>
		<option <?= ($taille=="m") ? 'selected' :''?> value="m" name="homme">  Homme</option>
		<option <?= ($taille=="mixte") ? 'selected' :''?> value="mixte" name="mixte">Mixte</option>
		
	</select><br/>
	<?php if(isset($produit_a_modifier)) :?>
		<img src=" <?=RACINE_SITE?>photo/<?= $produit_a_modifier['photo'] ?>" height="100"/>
		<input type="hidden" name="photo_actuelle" value="<?=$photo?>"/>
	<?php endif; ?>
	
	 <label>Photo</label><br/>
	<input type="file" name="photo"  value="<?= $photo ?>"/><br/><br/>

	
	
	
	<input type="submit" value="Enregistrement"/>




</form>

<?php
require_once('../inc/footer.inc.php');

?>