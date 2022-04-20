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
$sql = "UPDATE commande SET date_heure_depart = :date_depart, date_heure_fin = :date_fin, 
prix_total = :prix, id_membre = :id_membre, id_vehicule = :id_vehicule, 
id_agence = :id_agence WHERE id_commande = :id";
$requete = $bdd->prepare($sql);
$requete->bindValue(":date_depart", date("Y-m-d h:i:s", strtotime($_POST['date_debut'])), PDO::PARAM_STR);
$requete->bindValue(":date_fin", date("Y-m-d h:i:s", strtotime($_POST['date_fin'])), PDO::PARAM_STR);
$requete->bindValue(":prix", $_POST['prix'], PDO::PARAM_INT);
$requete->bindValue(":id_membre", $_POST['membre'], PDO::PARAM_INT);
$requete->bindValue(":id_vehicule", $_POST['vehicule'], PDO::PARAM_INT);
$requete->bindValue(":id_agence", $_POST['agence'], PDO::PARAM_INT);
$requete->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
$requete->execute();

var_dump($requete);

header("Location: list_commande.php");
