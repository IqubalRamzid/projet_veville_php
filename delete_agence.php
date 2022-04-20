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

$bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", "root", "root");
$sql = "DELETE FROM agences WHERE id_agence = :id";
$requete = $bdd->prepare($sql);
$requete->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$requete->execute();

header('Location: list_agence.php');
