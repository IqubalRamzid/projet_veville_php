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
    $sql = "SELECT * FROM membre";
    $requete = $bdd->prepare($sql);
    $requete->execute();

    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
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
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php

            foreach ($resultat as $membre) {
                if ($membre['statut'] == 0) {
                    $membre['statut'] = "admin";
                } else {
                    $membre['statut'] = "membre";
                }

                $date = date("d/m/Y", strtotime($membre['date_enregistrement']));
                echo "<tr><td>" . $membre['id_membre'] . "</td><td>" .
                    $membre['pseudo'] . "</td><td>" .
                    $membre['nom'] . "</td><td>" .
                    $membre['prenom'] . "</td><td>" .
                    $membre['email'] . "</td><td>" .
                    $membre['civilite'] . "</td><td>" .
                    $membre['statut'] . "</td><td>" .
                    $date . "</td><td>" .
                    "<a href='show_membre.php?id=" . $membre['id_membre'] . "'><i class=\"fa-solid fa-magnifying-glass\"></a>" .
                    "<a href='form_update_membre.php?id=" . $membre['id_membre'] . "'><i class='fa-solid fa-pencil'></a>" .
                    "<a href='delete_membre.php?id=" . $membre['id_membre'] . "'><i class='fa-solid fa-trash'></a></td></tr>";
            }

            ?>
        </tbody>

    </table>

    <form action="create_membre.php" method="post">

        <div class="form">
            <div class="form-left">

                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo">

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom">

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom">

                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp">

            </div>

            <div class="form-right">

                <label for="mail">Email</label>
                <input type="email" name="mail" id="mail">

                <label for="civilite">Civilité</label>
                <input type="text" name="civilite" id="civilite">

                <label for="statut">Statut</label>
                <select name="statut" id="statut">
                    <option value="0">Admin</option>
                    <option value="1">Membre</option>
                </select>

            </div>

        </div>

        <div class="bouton">
            <input type="submit" value="Enregistrer" class="button">
        </div>



    </form>

</body>

</html>