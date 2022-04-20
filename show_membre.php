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
    $sql = "SELECT * FROM membre WHERE id_membre = :id";
    $requete = $bdd->prepare($sql);
    $requete->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    //var_dump($resultat);


    ?>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Pseudo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Civilité</th>
                <th>Statut</th>
                <th>Date d'enregistrement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php

                if ($resultat['statut'] == 0) {
                    $resultat['statut'] = "admin";
                } else {
                    $resultat['statut'] = "membre";
                }

                $date = date("d/m/Y", strtotime($resultat['date_enregistrement']));

                echo "<td>" . $resultat['id_membre'] . "</td><td>" .
                    $resultat['pseudo'] . "</td><td>" .
                    $resultat['nom'] . "</td><td>" .
                    $resultat['prenom'] . "</td><td>" .
                    $resultat['email'] . "</td><td>" .
                    $resultat['civilite'] . "</td><td>" .
                    $resultat['statut'] . "</td><td>" .
                    $date  . "</td>"

                ?>
            </tr>
        </tbody>
    </table>

</body>

</html>