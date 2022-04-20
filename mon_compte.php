<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <?php

    if (empty($_SESSION['pseudo']) && empty($_SESSION['nom']) && empty($_SESSION['prenom']) && empty($_SESSION['email']) && empty($_SESSION['statut'])) {
        header('Location: login.php');
    } else {
        echo "<h2>Compte de " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . " alias " . $_SESSION['pseudo'] . "</h2>";
        //var_dump($_SESSION);
        $bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", "root", "root");
        $sql = "SELECT * FROM commande INNER JOIN membre ON commande.id_membre =  membre.id_membre
        INNER JOIN vehicule ON vehicule.id_vehicule = commande.id_vehicule
        INNER JOIN agences ON commande.id_agence = agences.id_agence
        WHERE membre.nom = :nom AND membre.prenom = :prenom AND membre.email = :email AND membre.statut = :statut AND membre.pseudo = :pseudo";
        $requete = $bdd->prepare($sql);
        $requete->bindValue(":nom", $_SESSION['nom'], PDO::PARAM_STR);
        $requete->bindValue(':prenom', $_SESSION['prenom'], PDO::PARAM_STR);
        $requete->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
        $requete->bindValue(':statut', $_SESSION['statut'], PDO::PARAM_INT);
        $requete->bindValue(':pseudo', $_SESSION['pseudo'], PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($resultat);
    }

    ?>

    <table>
        <thead>
            <tr>
                <th>Commande</th>
                <th>Vehicule</th>
                <th>Agence</th>
                <th>Date de départ</th>
                <th>Date de fin</th>
                <th>Prix total</th>
                <th>Date d'enregistrement</th>
            </tr>
        </thead>
        <tbody>
            <?php


            foreach ($resultat as $commande) {
                $date_debut = date('d/m/Y h-i-s', strtotime($commande['date_heure_depart']));
                $date_fin = date("d/m/Y h-i-s", strtotime($commande['date_heure_fin']));
                $date = date('d/m/Y', strtotime($commande['date_enregistrement']));

                echo "<tr><td>" . $commande['id_commande'] . "</td><td>" .
                    $commande['id_vehicule'] . " - " . $commande['marque'] . " " . $commande['modele'] . "</td><td>" .
                    $commande['id_agence'] . " - " . $commande['enseigne'] . "</td><td>" .
                    $date_debut . "</td><td>" .
                    $date_fin . '</td><td>' .
                    $commande['prix_total'] . "</td><td>" .
                    $date . "</td></tr>";
            }


            ?>
        </tbody>
    </table>

    <a href="login.php">Se déconnecter</a>


</body>

</html>