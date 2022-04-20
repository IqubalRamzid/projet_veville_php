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

    $bdd = new PDO("mysql:host=localhost;port=3307;dbname=veville", "root", "root");
    $sql = "SELECT * FROM agences";
    $requete = $bdd->prepare($sql);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    //var_dump($resultat);

    ?>

    <table>
        <thead>
            <tr>
                <th>Agence</th>
                <th>Enseigne</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code Postal</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <?php

            foreach ($resultat as $agence) {
                echo "<tr><td>" . $agence['id_agence'] . "</td><td>" .
                    $agence['enseigne'] . "</td><td>" .
                    $agence['adresse'] . "</td><td>" .
                    $agence['ville'] . "</td><td>" .
                    $agence['cp'] . "</td><td>" .
                    $agence['description'] . "</td><td>" .
                    "<img src='img/" . $agence['photo'] . "'></td><td>" .
                    "<a href='show_agence.php?id=" . $agence['id_agence'] . "'><i class=\"fa-solid fa-magnifying-glass\"></a>" .
                    "<a href='update_form_agence.php?id=" . $agence['id_agence'] . "'><i class='fa-solid fa-pencil'></a>" .
                    "<a href='delete_agence.php?id=" . $agence['id_agence'] . "'><i class='fa-solid fa-trash'></a></td></tr>";
            }

            ?>

        </tbody>

    </table>

    <form action="add_agence.php" method="post" enctype="multipart/form-data">

        <div class="form">
            <div class="form-left">

                <label for="enseigne">Enseigne</label>
                <input type="text" name="enseigne" id="enseigne">

                <label for="description">Description</label>
                <textarea name="description" id="description" cols="20" rows="5"></textarea>

                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo">

            </div>

            <div class="form-right">

                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse">

                <label for="ville">Ville</label>
                <input type="text" name="ville" id="ville">

                <label for="cp">Code Postal</label>
                <input type="number" name="cp" id="cp">

            </div>

        </div>

        <div class="bouton">
            <input type="submit" value="Enregistrer" class="button">
        </div>



    </form>

</body>

</html>