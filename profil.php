<?php
require_once('inc/init.inc.php');

//Redicrection si user n'est pas connecte:
if(!userConnecte() ){
	header('location:connexion.php');
}

debug($_SESSION);
extract($_SESSION['membre']);

$page='Profil';

require_once('inc/haut.inc.php'); 
require_once('inc/header.inc.php'); 

?>


<h1>Profil de <?= $pseudo ?> !</h1>

	<div class="profil">
		<p> Bonjour <?= $pseudo ?> </p><br/>
		<div class="profil_img">
			<img src="img/default.png"/>
		</div>
		<div class="profil_infos">
			<ul>
				<li>Prenom: <?= $prenom ?></li>
				<li>Nom: <?= $nom ?></li>
				<li>Pseudo: <?= $pseudo ?></li>
				<li>Email: <?= $email ?></li>
				
			</ul>
		</div>	
		<div class="profil_adresse">
			<ul>
				<li>Adresse: <?= $adresse ?></li>
				<li>Code-Postal: <?= $code_postal ?></li>
				<li>Ville: <?= $ville ?></li>
			
			
			
			</ul>
		</div>
	</div>















<?php
require_once('inc/footer.inc.php');

?>