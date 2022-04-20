<?php
session_start();
?>
<?php

if (empty($_SESSION['nom']) && empty($_SESSION['prenom']) && empty($_SESSION['pseudo']) && empty($_SESSION['email']) && empty($_SESSION['statut'])) {
    header("Location: login.php");
}
if ($_SESSION['statut'] == 1) {
    header("Location: mon_compte.php");
}

$nom_fichier = $_FILES['image']['name'];
$fichier = $_FILES['image']['tmp_name'];
$dossier = "img/" . $nom_fichier;

move_uploaded_file($fichier, $dossier);

$bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", 'root', 'root');
$sql = "UPDATE vehicule SET titre = :titre, modele = :modele, marque = :marque, description = :description, 
prix_journalier = :prix, id_agence = :id_agence, image = :image WHERE id_vehicule = :id";
$requete = $bdd->prepare($sql);
$requete->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
$requete->bindValue(':marque', $_POST['marque'], PDO::PARAM_STR);
$requete->bindValue(':modele', $_POST['modele'], PDO::PARAM_STR);
$requete->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
$requete->bindValue(':image', $nom_fichier, PDO::PARAM_STR);
$requete->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
$requete->bindValue(':id_agence', $_POST['agence'], PDO::PARAM_INT);
$requete->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$requete->execute();

header("Location: vehicule_list.php");
