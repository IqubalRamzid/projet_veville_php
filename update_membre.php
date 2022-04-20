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

$bdd = new PDO('mysql:host=localhost;port=3307;dbname=veville', 'root', 'root');
$sql = "UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, email = :mail, civilite = :civilite, statut = :statut, mdp = :mdp WHERE id_membre = :id";
$requete = $bdd->prepare($sql);
$requete->bindValue(":pseudo", $_POST["pseudo"], PDO::PARAM_STR);
$requete->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
$requete->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
$requete->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
$requete->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
$requete->bindValue(':statut', $_POST['statut'], PDO::PARAM_INT);
$requete->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
$requete->bindValue(":id", $_POST['id'], PDO::PARAM_STR);

$requete->execute();

header('Location: list_membre.php');
