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

$dossier = "img/";
$photo = $_FILES['photo']['tmp_name'];
$nom_photo = $_FILES['photo']['name'];

move_uploaded_file($photo, $dossier . $nom_photo);

var_dump($_FILES);

$bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", "root", "root");
$sql = "INSERT INTO agences (enseigne, adresse, ville, cp, description, photo) VALUES (:enseigne, :adresse, :ville, :cp, :description, :photo)";
$requete = $bdd->prepare($sql);
$requete->bindValue(':enseigne', $_POST['enseigne'], PDO::PARAM_STR);
$requete->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
$requete->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
$requete->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
$requete->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
$requete->bindValue(':photo', $_FILES['photo']['name'], PDO::PARAM_STR);
$requete->execute();

header('Location: list_agence.php');
