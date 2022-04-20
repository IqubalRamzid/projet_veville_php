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
    $sql = "SELECT * FROM commande INNER JOIN membre ON membre.id_membre = commande.id_membre
    INNER JOIN vehicule ON vehicule.id_vehicule = commande.id_vehicule
    INNER JOIN agences ON agences.id_agence = commande.id_agence WHERE id_commande = :id";
    $requete = $bdd->prepare($sql);
    $requete->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    //var_dump($resultat);

    $sql_membre = "SELECT * FROM membre";
    $requete_membre = $bdd->prepare($sql_membre);
    $requete_membre->execute();
    $resultat_membre = $requete_membre->fetchAll(PDO::FETCH_ASSOC);

    //var_dump($resultat_membre);

    $sql_agences = "SELECT * FROM agences";
    $requete_agences = $bdd->prepare($sql_agences);
    $requete_agences->execute();
    $resultat_agences = $requete_agences->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($resultat_agences);

    $sql_vehicule = "SELECT * FROM vehicule";
    $requete_vehicule = $bdd->prepare($sql_vehicule);
    $requete_vehicule->execute();
    $resultat_vehicule = $requete_vehicule->fetchAll(PDO::FETCH_ASSOC);

    //var_dump($resultat_vehicule);

    ?>

    <form action="update_commande.php" method="post">

        <div class="form">
            <div class="form-left">

                <input type="number" name="id" id="id" value="<?php echo $resultat['id_commande'] ?>" class="d-n">

                <label for="date_debut">Date et heure de début</label>
                <input type="datetime-local" name="date_debut" id="date_debut" value="<?php echo $resultat['date_heure_debut'] ?>">

                <label for="date_fin">Date et heure de fin</label>
                <input type="datetime-local" name="date_fin" id="date_fin" value="<?php echo $resultat['date_heure_fin'] ?>">

                <label for="prix">Prix</label>
                <input type="number" name="prix" id="prix" value="<?php echo $resultat['prix_total'] ?>">

            </div>
            <div class="form-right">

                <label for="membre">Membre</label>
                <select name="membre" id="membre">
                    <?php
                    foreach ($resultat_membre as $membre) {
                        if ($resultat['id_membre'] == $membre['id_membre']) {
                            echo "<option value='" . $membre['id_membre'] . "' selected>" . $membre['nom'] . " " . $membre['prenom'] . "</option>";
                        } else {
                            echo "<option value='" . $membre['id_membre'] . "'>" . $membre['nom'] . " " . $membre['prenom'] . "</option>";
                        }
                    }
                    ?>
                </select>

                <label for="vehicule">Vehicule</label>
                <select name="vehicule" id="vehicule">
                    <?php
                    foreach ($resultat_vehicule as $vehicule) {
                        if ($resultat['id_vehicule'] == $vehicule['id_vehicule']) {
                            echo "<option value='" . $vehicule['id_vehicule'] . "' selected>" . $vehicule['marque'] . " " . $vehicule['modele'] . "</option>";
                        } else {
                            echo "<option value='" . $vehicule['id_vehicule'] . "'>" . $vehicule['marque'] . " " . $vehicule['modele'] . "</option>";
                        }
                    }
                    ?>
                </select>

                <label for="agence">Agence</label>
                <select name="agence" id="agence">
                    <?php
                    foreach ($resultat_agences as $agence) {
                        if ($resultat['id_agence'] == $agence['id_agence']) {
                            echo "<option value='" . $agence['id_agence'] . "' selected>" . $agence['enseigne'] . " " . $agence['ville'] . "</option>";
                        } else {
                            echo "<option value='" . $agence['id_agence'] . "'>" . $agence['enseigne'] . " " . $agence['ville'] . "</option>";
                        }
                    }
                    ?>
                </select>

            </div>

        </div>

        <div class="bouton">
            <input type="submit" value="Enregistrer" class="button">
        </div>
    </form>

</body>

</html>