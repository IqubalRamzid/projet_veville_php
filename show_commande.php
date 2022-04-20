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

    if (empty($_SESSION['nom']) && empty($_SESSION['prenom']) && empty($_SESSION['pseudo']) && empty($_SESSION['email']) && empty($_SESSION['statut'])) {
        header("Location: login.php");
    }
    if ($_SESSION['statut'] == 1) {
        header("Location: mon_compte.php");
    }

    $bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", "root", "root");
    $sql = "SELECT * FROM commande INNER JOIN membre ON commande.id_membre = membre.id_membre 
    INNER JOIN vehicule ON commande.id_vehicule = vehicule.id_vehicule
    INNER JOIN agences ON agences.id_agence = commande.id_agence
    WHERE id_commande = :id";
    $requete = $bdd->prepare($sql);
    $requete->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    //var_dump($resultat);

    ?>

    <table>
        <thead>
            <tr>
                <th>Commande</th>
                <th>Membre</th>
                <th>Vehicule</th>
                <th>Agence</th>
                <th>Date et heure de départ</th>
                <th>Date et heure d'arrivée</th>
                <th>Prix total</th>
                <th>Date et heure d'enregistrement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php

                echo "<td>" . $resultat['id_commande'] . "</td><td>" .
                    $resultat['id_membre'] . " - " . $resultat['prenom'] . " " . $resultat['nom'] . " - " . $resultat['email'] . "</td><td>" .
                    $resultat['id_vehicule'] . " - " . $resultat['marque'] . " " . $resultat['modele'] . "</td><td>" .
                    $resultat['id_agence'] . " - " . $resultat['enseigne'] . "</td><td>" .
                    $resultat['date_heure_depart'] . "</td><td>" .
                    $resultat['date_heure_fin'] . "</td><td>" .
                    $resultat['prix_total'] . "</td><td>" .
                    $resultat['date_enregistrement'] . "</td></tr>";

                ?>
            </tr>
        </tbody>
    </table>

</body>

</html>