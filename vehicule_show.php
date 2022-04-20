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

    $bdd = new PDO('mysql:host=localhost;port=3307;dbname=veville', 'root', 'root');
    $sql = "SELECT * FROM vehicule INNER JOIN agences ON agences.id_agence = vehicule.id_agence WHERE id_vehicule = :id";
    $requete = $bdd->prepare($sql);
    $requete->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    ?>

    <table>

        <thead>
            <tr>
                <th>Vehicule</th>
                <th>Agence</th>
                <th>Titre</th>
                <th>Marque</th>
                <th>Modele</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Prix</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <?php

                echo "<td>" . $resultat['id_vehicule'] . "</td><td>" .
                    $resultat['enseigne'] . "</td><td>" .
                    $resultat['titre'] . "</td><td>" .
                    $resultat['marque'] . "</td><td>" .
                    $resultat['modele'] . "</td><td>" .
                    $resultat['description'] . "</td><td>" .
                    "<img src='img/" . $resultat['image'] . "'>"  . "</td><td>" .
                    $resultat['prix_journalier']  . "</td></tr>";
                ?>
            </tr>
        </tbody>
    </table>

</body>

</html>