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

    <form action="update_vehicule.php" method="post" enctype="multipart/form-data">

        <input type="number" name="id" id="id" value="<?php echo $_GET['id'] ?>" class="d-n">


        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value=" <?php echo $resultat['titre'] ?> ">

        <label for="marque">Marque</label>
        <input type="text" name="marque" id="marque" value=" <?php echo $resultat['marque'] ?> ">

        <label for="modele">Modele</label>
        <input type="text" name="modele" id="modele" value=" <?php echo $resultat['modele'] ?> ">

        <label for="prix">Prix</label>
        <input type="text" name="prix" id="prix" value=" <?php echo $resultat['prix_journalier'] ?> ">

        <label for="image">Image</label>
        <input type="file" name="image" id="image">

        <label for="agence">Agence</label>
        <select name="agence" id="agence">

            <?php

            foreach ($resultat as $agence) {
                if ($resultat['id_agence'] == $agence['id_agence']) {
                    echo "<option value='" . $agence['id_agence'] . "' selected>" . $agence['enseigne'] . "</option>";
                }
                echo "<option value='" . $agence['id_agence'] . "'>" . $agence['enseigne'] . "</option>";
            }

            ?>


        </select>

        <label for="description">Description</label>
        <textarea name="description" id="" cols="30" rows="10">
            <?php echo $resultat['description'] ?>
        </textarea>

        <input type="submit" value="Enregistrer">

    </form>


</body>

</html>