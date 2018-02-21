<?php
//Affichage des produit avec la possibilité de les modifier, les supprimer et en ajouter.

require_once('../inc/init.inc.php');

if(!userAdmin()){
	header('location:'.RACINE_SITE.'connexion.php');
} 

$page='Gestion Boutique';


require_once('../inc/haut.inc.php'); 
require_once('../inc/header.inc.php'); 
?>

<?php  





$resultat = $pdo->query("SELECT*FROM produit");
$contenu .= "<table border='1'>";
$contenu .= "<tr>";
for ($i=0; $i < $resultat->columnCount(); $i++) { 
	$champs=$resultat->getcolumnMeta($i);
	$contenu .= "<th>".$champs["name"]."</th>";
}
$contenu .= "</tr>";
while ($infos =$resultat->fetch(PDO::FETCH_ASSOC)) {
	$contenu .= "<tr>";
	foreach ($infos as $key => $value) {
		
		if($key=='photo'){
			$contenu .= '<td><img src="' . RACINE_SITE . 'photo/'. $value. '"height="80"/></td>';
		}
		else{
			$contenu .= "<td>".$value."</td>";
		}
	}
	$contenu.= "<td><a href='formulaire_produit.php?id=".$infos["id_produit"]."'><img src='" . RACINE_SITE . "img/" . "edit.png'></a></td>";
	$contenu.= "<td><a href='supprimer_produit.php?id=".$infos["id_produit"]."'><img src='" . RACINE_SITE . "img/" . "delete.png'></a></td>";
	$contenu.= "</tr>";
}
$contenu .= "</table>";











?>




<h1>Gestion de la boutique</h1>
<a style="padding:5px 15px; border: 1px solid:#98DE32; background:skyblue; color:#98DE32; font-weight:bold; border-radius: 3px; display:block; width: 150px; margin-bottom:20px;" href="formulaire_produit.php">Ajouter un produit</a>

<?=$contenu  ?>




<?php
require_once('../inc/footer.inc.php');

?>