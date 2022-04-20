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
    $sql = "SELECT * FROM commande INNER JOIN vehicule ON commande.id_vehicule = vehicule.id_vehicule INNER JOIN agences ON commande.id_agence = agences.id_agence
    INNER JOIN membre ON commande.id_membre = membre.id_membre";
    $requete = $bdd->prepare($sql);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($resultat as $commande) {
                echo "<tr><td>" . $commande['id_commande'] . "</td><td>" .
                    $commande['id_membre'] . " - "  . $commande['nom'] . " " . $commande['prenom'] . " - " . $commande['email'] . "</td><td>" .
                    $commande['id_vehicule'] . " - " . $commande['marque'] . " " . $commande['modele'] . "</td><td>" .
                    $commande['id_agence'] . " - " . $commande['enseigne'] . "</td><td>" .
                    $commande['date_heure_depart'] . "</td><td>" .
                    $commande['date_heure_fin'] . "</td><td>" .
                    $commande['prix_total'] . "</td><td>" .
                    $commande['date_enregistrement'] . "</td><td>" .
                    "<a href='show_commande.php?id=" . $commande['id_commande'] . "'><i class=\"fa-solid fa-magnifying-glass\"></a>" .
                    "<a href='form_update_commande.php?id=" . $commande['id_commande'] . "'><i class='fa-solid fa-pencil'></a>" .
                    "<a href='delete_commande.php?id=" . $commande['id_commande'] . "'><i class='fa-solid fa-trash'></a></td></tr>";
            }

            ?>
        </tbody>
    </table>
</body>

</html>