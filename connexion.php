<?php
require_once('inc/init.inc.php');

//Redicrection si user est déja connecte:
if(userConnecte() ){
	header('location: profil.php');
}
debug($_POST);

if($_POST){
	
		$resultat=$pdo->prepare("SELECT* FROM membre WHERE pseudo=:pseudo");
		$resultat->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$resultat->execute();
		
		//Comment savoir, donc si le pseudo existe??
		if($resultat->rowCount()>0){//Cela signifie que j'ai trouvé un enregistrement avec ce pseudo dans la BDD, donc ce pseudo existe bien!!
			$membre=$resultat-> fetch();//On est en mode PDO::FETCH_ASSOC par défaut...pour rappel
			
			if($membre['mdp']===md5($_POST['mdp'])){//Le MDP trouvé dans la BDD correspond t-il au mdp crypté saisi dans le formulaire? Si oui tout va bien il s'agit d'un membre de notre site:On peut se connecter
				foreach($membre as $indice=>$valeur){
					if($indice !='mdp'){
						$_SESSION['membre'][$indice]=$valeur;
					}
				}
				header('location:profil.php');
			}
			else{
				$msg .= '<p style="background:blue;">Vous vous etes trompé de MDP</p>';
			}
			

		}
		
		else{
			
				$msg .='<p style="background:blue;">Ce pseudo n\'existe pas</p>';
		}
		
		
	
	
	
	
	
}






















$page='Connexion';



require_once('inc/haut.inc.php');
require_once('inc/header.inc.php');



?>
<h1>Connexion!</h1>
<form method="post" action="">
<label>Pseudo</label>
<input type="text" name="pseudo"/>
<label> Mot de passe</label>
<input  type="password" name="mdp"/>

<input type="submit" value="Connexion"/>



</form>

<?php
echo $msg;

?>



<?php
require_once('inc/footer.inc.php');

?>