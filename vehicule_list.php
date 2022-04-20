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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    $sql = "SELECT * FROM agences INNER JOIN vehicule ON agences.id_agence = vehicule.id_agence";
    $requete = $bdd->prepare($sql);
    $requete->execute();

    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    //var_dump($resultat);
    //var_dump($_SESSION);

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
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php

            foreach ($resultat as $vehicule) {
                echo "<tr><td>" . $vehicule['id_vehicule'] . "</td><td>" .
                    $vehicule['enseigne'] . "</td><td>" .
                    $vehicule['titre'] . "</td><td>" .
                    $vehicule['marque'] . "</td><td>" .
                    $vehicule['modele'] . "</td><td>" .
                    $vehicule['description'] . "</td><td>" .
                    "<img src='img/" .  $vehicule['image'] . "'></td><td>" .
                    $vehicule['prix_journalier'] . "</td><td>" .
                    "<a href='vehicule_show.php?id=" . $vehicule['id_vehicule'] .
                    "'><i class=\"fa-solid fa-magnifying-glass\"></i></a><a href='vehicule_form_update.php?id="
                    . $vehicule['id_vehicule'] . "'><i class='fa-solid fa-pencil'></i></a><a href='delete_vehicule.php?id=" .
                    $vehicule['id_vehicule'] . "'><i class='fa-solid fa-trash'></i></a></td></tr>";
            }

            ?>
        </tbody>


    </table>

    <form action="add_vehicule.php" method="post" enctype="multipart/form-data">

        <div class="form">
            <div class="form-left">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre">

                <label for="marque">Marque</label>
                <input type="text" name="marque" id="marque">

                <label for="modele">Modele</label>
                <input type="text" name="modele" id="modele">

                <label for="prix">Prix</label>
                <input type="text" name="prix" id="prix">
            </div>

            <div class="form-right">
                <label for="image">Image</label>
                <input type="file" name="image" id="image">

                <label for="agence">Agence</label>
                <select name="agence" id="agence">

                    <?php

                    foreach ($resultat as $agence) {
                        echo "<option value='" . $agence['id_agence'] . "'>" . $agence['enseigne'] . "</option>";
                    }

                    ?>


                </select>

                <label for="description">Description</label>
                <textarea name="description" id="" cols="30" rows="10"></textarea>


            </div>
        </div>

        <div class="bouton">
            <input type="submit" value="Enregistrer" class="button">
        </div>


    </form>

</body>

</html>