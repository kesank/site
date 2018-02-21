<?php 
require_once('inc/init.inc.php');

if ($_POST) {
	debug($_POST);
	if (!empty($_POST['pseudo'])) {
		$verif_pseudo =preg_match('#^[a-zA-Z0-9-._]{3,20}$#',$_POST['pseudo']);//cette fonction nous permet de définir les caractères autorisés dans une chaîne de caractère. Elle prend 2 arguments.
		//1 les REGEX ou Expressions régulières
		//2 la chaîne de caractère.
		if (!$verif_pseudo) {//si le speudo n'est bien composé de 3 à 20 caractères autorisé.
			$msg.="<div class= 'erreur'>Veuillez renseigner un pseudo valide : 3 à 20 caractères, lettres et chiffres uniquement.</div>";
		}
	}
	else{

		$msg .="<div class='erreur'>Veuillez renseigner un pseudo !</div>";
	}

	if (!empty($_POST['mdp'])) {
		$verif_mdp =preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*\'$@%_])([-+!*$\'@%_\w]{8,15})$#', $_POST['mdp']);//cette fonction nous permet de définir les caractères autorisés dans une chaîne de caractère. Elle prend 2 arguments.
		//1 les REGEX ou Expressions régulières
		//2 la chaîne de caractère.
		//tous les regex :  http://41mag.fr/regexp-php-les-8-expressions-regulieres-les-plus-utilisees.html
		if (!$verif_mdp) {//si le speudo n'est bien composé de 3 à 20 caractères autorisé.
			$msg.="<div class= 'erreur'>Veuillez renseigner un mot de passe composé de 8 caractères : Au moins une majuscule, une minuscule, un chiffre et un caractère spéciale.</div>";
		}
	}
	else{

		$msg .="<div class='erreur'>Veuillez renseigner un mot de passe</div>";
	}
	//Verification pour l'email
	if(!empty($_POST['email'])){
		
		$verif_email=filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
		//filter_var nous permet de vérifier qu'un CC est bien un email ou une url (FILTER_VALIDATE_URL), ou un Boolean (FILTER_VALIDATE_BOOLEAN)
		$dom_interdit= array(
			'mailinator.com',
			'yopmail.com',
			'mail.com'

		);
		$dom_email=explode('@', $_POST['email'] );
		//$dom_email[1]==>ce qui suit le @ dans l'email de l'utilisateur
		if(!$verif_email || in_array($dom_email[1], $dom_interdit)){
			//Est ce que l'email n'est pas un email, et est ce qui suit le '@' correspond à l'un des domaines interdit? Dans ce cas nous n'accepton pas l'email de l'utilisateur.
			$msg .= '<div class="erreur"> Veuillez renseigner un email valide!</div>';
			
		}
		
	}
	else{
		$msg .='<div class"erreur">Veuillez renseigner un email!</div>';
	}
	//TOUT EST OK si $MSG EST VIDE
	if(empty($msg)){
		//Aucun message d'erreur à ce stade, donc tout est bien renseigné, donc on va pouvoir s'interesser à enregistrer l'utilisateur l'utilisateur en BDD mais...
		//...le pseudo est il disponible:
		$resultat=$pdo->prepare("SELECT* FROM membre WHERE pseudo=:pseudo");
		$resultat->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$resultat->execute();
		
		/* if($resultat->rowCount()>0){
		if($resultat->rowCount()!=0){ */
		if($resultat->rowCount()==1){ // Cela signifie que lap seudo existe déja dans la BDD, il n'est pas disponible.
			$msg .= '<div class="erreur"> le pseudo'.$_POST['pseudo']. 'n\'est malheuresement pas disponible. Veuillez choisir un autre pseudo. </div>';
			
			//ICI on pourrait lui proposer un pseudo de substitution à condition de tester la dispo de ces pseudos également.
			/* $new_pseudo1= $_POST['pseudo'].rand.(1,999);
			$new_pseudo2= $_POST['pseudo'].substr.(1,999);
			$new_pseudo3= $_POST['pseudo'].rand.(1,999);
		 */
		
		}
		else{//Le pseudo est donc disponible
			// Normalement nous devrions également vérifier que l'email est aussi disponible. IF/ELSE.Si l'email n'est pas dispo, il y a des chances que l'tutilisateur est oublié son MDP

			//Nous pouvons enregistrer l'utilisateur en BDD
			$resultat =$pdo->prepare("INSERT INTO membre(pseudo,mdp,nom,prenom,email,civilite,ville,code_postal,adresse,statut) VALUES(:pseudo,:mdp,:nom,:prenom,:email,:civilite,:ville,:code_postal,:adresse,0)");

			$resultat->bindParam(':pseudo',$_POST['pseudo'],PDO::PARAM_STR);
			
			
			//MDP
			$mdp_crypte=md5($_POST['mdp']);
			$resultat->bindParam(':mdp',$mdp_crypte,PDO::PARAM_STR);
			$resultat->bindParam(':nom',$_POST['nom'],PDO::PARAM_STR);
			$resultat->bindParam(':prenom',$_POST['prenom'],PDO::PARAM_STR);
			$resultat->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
			$resultat->bindParam(':ville',$_POST['ville'],PDO::PARAM_STR);
			$resultat->bindParam(':adresse',$_POST['adresse'],PDO::PARAM_STR);
			$resultat->bindParam(':civilite',$_POST['civilite'],PDO::PARAM_STR);
			//INT
			$resultat->bindParam(':code_postal',$_POST['code_postal'],PDO::PARAM_STR);
			if($resultat->execute()){//Si la requete s'est bien passée
			$msg .= '<div class="validation"> Felicitations, vous etes enregistré! </div>';
			header('location:connexion.php');//On ne redirige l'internaute que si la requete s'est bien déroulée
			}
		}
	
}
}
//Fin du if($_POST)
//Recupérer les infos saisies pour les remettre dans le formulaire;
$pseudo=(isset($_POST['pseudo'])) ? $_POST['pseudo']:'';
/* Correspond à faire ceci.
if(isset($_POST['pseudo'])){
	$pseudo=$_POST['pseudo'];
else{
	pseudo='';
}
}
*/	
$prenom=(isset($_POST['prenom'])) ? $_POST['prenom']:'';	
$nom=(isset($_POST['nom'])) ? $_POST['nom']:'';	
$ville=(isset($_POST['ville'])) ? $_POST['ville']:'';	
$code_postal=(isset($_POST['code_postal'])) ? $_POST['code_postal']:'';	
$adresse=(isset($_POST['adresse'])) ? $_POST['adresse']:'';	
$civilite=(isset($_POST['civilite'])) ? $_POST['civilite']:'';	
$email=(isset($_POST['email'])) ? $_POST['email']:'';	


$page='Inscription';

require_once('inc/haut.inc.php');
require_once('inc/header.inc.php');



?>
<h1>Inscription!</h1>
<form method="post" action="">
	
	<label >pseudo</label><br/>
	<input type="text"  name="pseudo" value= "<?= $pseudo ?>" /><br/><br/>
	
	<label >mot de passe</label><br/>
	<input type="password"  name="mdp" /><br/><br/>


	<label>Nom :</label><br/>
	<input type="text" name="nom" value="<?= $nom ?>" /><br/><br/>
	
	
	<label>Prenom:</label><br/>
	<input type="text" name="prenom" value="<?= $prenom ?>"/><br/><br/>
		
	<label >email</label><br/>
	<input type="email"  name="email" value="<?= $email ?>"/><br/><br/>
	
	<label >Ville</label><br/>
	<input type="text"  name="ville" value="<?= $ville ?>"/><br/><br/>
	
	<label>Code postal</label><br/>
	<input type="text" name="code_postal" maxlength="5" pattern="[0-9]{5}"  value="<?= $code_postal ?>"/><br/><br/>
	
	 <label>Adresse :</label><br/>
	 <textarea style="resize:none" name="adresse" value="<?= $adresse ?>" rows="8" cols="20"></textarea><br/><br/>
	
	
	<p>
		<label>Femme</label><input type="radio" name="civilite" value="f" checked>
		<label>Homme</label><input type="radio" name="civilite" value="m" <?= ($civilite == 'm') ? 'checked' : '' ?> >'	'
		
	</p>
	
	
	
	

	
	
	
	<input type="submit" value="Enregistrement"/>




</form>

<?php
echo $msg;

?>


<?php
require_once('inc/footer.inc.php');


?>