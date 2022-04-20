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
    $sql = "SELECT * FROM agences WHERE id_agence = :id";
    $requete = $bdd->prepare($sql);
    $requete->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    ?>

    <form action="update_agence.php" method="post" enctype="multipart/form-data">

        <input type="number" name="id" id="id" class="d-n" value="<?php echo $resultat['id_agence'] ?>">

        <label for="enseigne">Enseigne</label>
        <input type="text" name="enseigne" id="enseigne" value="<?php echo $resultat['enseigne'] ?>">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="20" rows="5">
            <?php echo $resultat['description'] ?>
        </textarea>

        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" value="<?php echo $resultat['adresse'] ?>">

        <label for="ville">Ville</label>
        <input type="text" name="ville" id="ville" value="<?php echo $resultat['ville'] ?>">

        <label for="cp">Code Postal</label>
        <input type="number" name="cp" id="cp" value="<?php echo $resultat['cp'] ?>">

        <label for="photo">Photo</label>
        <input type="file" name="photo" id="photo">

        <input type="submit" value="Enregistrer">


    </form>
</body>

</html>