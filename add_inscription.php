<?php

$bdd = new PDO('mysql:host=localhost;port=3307;dbname=veville', 'root', 'root');
$sql = "INSERT INTO membre (pseudo, nom, prenom, email, civilite, date_enregistrement, statut, mdp)
VALUES ( :pseudo, :nom, :prenom, :email, :civilite, :date, :statut, :mdp)";
$requete = $bdd->prepare($sql);
$requete->bindValue(":pseudo", $_POST['pseudo'], PDO::PARAM_STR);
$requete->bindValue(":nom", $_POST['nom'], PDO::PARAM_STR);
$requete->bindValue(":prenom", $_POST['prenom'], PDO::PARAM_STR);
$requete->bindValue(":email", $_POST['mail'], PDO::PARAM_STR);
$requete->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
$requete->bindValue(":date", date("Y-m-d"), PDO::PARAM_STR);
$requete->bindValue(':statut', 1, PDO::PARAM_INT);
$requete->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
$requete->execute();

header("Location: list_membre.php");
