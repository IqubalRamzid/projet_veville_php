<?php

session_start();

$bdd = new PDO('mysql:host=localhost;port=3307;dbname=veville', 'root', 'root');
$sql = "SELECT * FROM membre WHERE email = :email AND mdp = :mdp LIMIT 1";
$requete = $bdd->prepare($sql);
$requete->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$requete->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
$requete->execute();
$resultat = $requete->fetch(PDO::FETCH_ASSOC);

//var_dump($resultat);

if (!$resultat) {
    echo "Vous n'êtes pas encore inscrit : <a href='form_inscription.php'>S'inscrire</a>";
} else {
    $_SESSION['pseudo'] =  $resultat['pseudo'];
    $_SESSION['nom'] = $resultat['nom'];
    $_SESSION['prenom'] = $resultat['prenom'];
    $_SESSION['email'] = $resultat['email'];
    $_SESSION['statut'] = $resultat['statut'];

    header('Location: mon_compte.php');
}
