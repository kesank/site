
INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(1, 'juju', '23206deb7eba65b3fbc80a2ffbc53c28', 'Cottet', 'Julien', 'julien.cottet@gmail.com', 'm', 'Paris', 75015, '300 rue de vaugirard', 0),
(2, 'lamarie', 'e24755cbd680d6baa5c51dca46dee1a9', 'thoyer', 'marie', 'marie.thoyer@yahoo.fr', 'f', 'Lyon', 69003, '10 rue paul bert', 0),
(3, 'fab', '3ec049f667072f4bba034438abe6f0c4', 'grand', 'fabrice', 'fabrice.grand@gmail.com', 'm', 'Marseille', 13009, '70 rue de la r&eacute;publique', 0),
(4, 'membre', '5a99c8cac333affeed05a24fe0d6f61c', 'membre', 'membre', 'membre@exemple.com', 'f', 'Toulouse', 31000, '55 rue bayard', 0),
(5, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'admin@exemple.com', 'm', 'Paris', 75015, '33 rue mademoiselle', 1),
(6, 'test', '098f6bcd4621d373cade4e832627b4f6', 'Test', 'test', 'test@testtest.com', 'm', 'test', 02315, 'test test test', 0);


INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(4, '55-b-38', 'tshirt', 'Tshirt jaune', 'le jaune reviens &agrave; la mode, non? :-)', 'jaune', 'S', 'm', '55-b-38_jaune.png', 20, 3),
(5, '31-p-33', 'tshirt', 'Tshirt noir original', 'voici un tshirt noir tr&egrave;s original :p', 'noir', 'XL', 'm', '31-p-33_noir.jpg', 25, 80),
(6, '56-a-65', 'chemise', 'Chemise Blanche', 'Les chemises c''est bien mieux que les tshirts', 'blanc', 'L', 'm', '56-a-65_chemiseblanchem.jpg', 49, 73),
(7, '63-s-63', 'chemise', 'Chemise Noir', 'Comme vous pouvez le voir c''est une chemise noir...', 'noir', 'M', 'm', '63-s-63_chemisenoirm.jpg', 59, 120),
(8, '77-p-79', 'pull', 'Pull gris', 'Pull gris pour l''hiver', 'gris', 'XL', 'f', '77-p-79_pullgrism2.jpg', 79, 99);

INSERT INTO `commande` (`id_commande`, `id_membre`, `montant`, `date_enregistrement`, `etat`) VALUES
(1, 4, 301, '2015-07-10 14:44:46', 'en cours de traitement');


INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_produit`, `quantite`, `prix`) VALUES
(1, 1, 2, 1, 15),
(2, 1, 6, 1, 49),
(3, 1, 8, 3, 79);