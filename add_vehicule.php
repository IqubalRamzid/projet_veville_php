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
$dossier_image = "img/" . $nom_fichier;

move_uploaded_file($fichier, $dossier_image);

$bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", "root", "root");
$sql = "INSERT INTO vehicule (titre, marque, modele, description, image, prix_journalier, id_agence) VALUES (:titre, :marque, :modele, :description, :image, :prix_journalier, :id_agence)";
$requete = $bdd->prepare($sql);
$requete->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
$requete->bindValue(':marque', $_POST['marque'], PDO::PARAM_STR);
$requete->bindValue(':modele', $_POST['modele'], PDO::PARAM_STR);
$requete->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
$requete->bindValue(':image', $nom_fichier, PDO::PARAM_STR);
$requete->bindValue(':prix_journalier', $_POST['prix'], PDO::PARAM_STR);
$requete->bindValue(':id_agence', $_POST['agence'], PDO::PARAM_INT);
$requete->execute();

header('Location: vehicule_list.php');
