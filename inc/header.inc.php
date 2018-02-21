 <header>
			<div class="conteneur">                      
				<span>
					<a href="index.php" title="Mon Site">MonSite.com</a>
                </span>
				<nav>
					<?php if(userConnecte() ): ?>
					<a href="<?= RACINE_SITE ?>profil.php" <?= ($page=='Profil')? 'class="active"':''?>>Profil</a>
					<a href="<?= RACINE_SITE ?>deconnexion.php" >Deconnexion</a>
					<?php else: ?>
					<a href="<?= RACINE_SITE ?>inscription.php" <?= ($page=='Inscription')? 'class="active"':''?> >Inscritpion</a>
					<a href="<?= RACINE_SITE ?>connexion.php" <?= ($page=='Connexion')? 'class="active"':''?> >Connexion</a>
					<?php endif; ?> 
				
				
					
					<a href="<?= RACINE_SITE ?>" <?= ($page=='Boutique')? 'class="active"':''?>>Accès à la boutique</a>
					<a href="<?= RACINE_SITE ?>" <?= ($page=='Panier')? 'class="active"':''?>>Voir votre panier</a>
					
					<?php if(userAdmin()): ?>
					<a href="<?= RACINE_SITE ?>backoffice/gestion_boutique.php" <?= ($page=='Gestion des boutiques')? 'class="active"':''?>>Gestion des boutiques</a>
					<a href="<?= RACINE_SITE ?>" <?= ($page=='Gestion des membres')? 'class="active"':''?>>Gestion de membres</a>
					<a href="<?= RACINE_SITE ?>" <?= ($page=='Gestion des commandes')? 'class="active"':''?>>Gestion des commandes</a>
					<?php endif; ?>
					
					
				</nav>
			</div>
        </header>
        <section>
			<div class="conteneur">       	