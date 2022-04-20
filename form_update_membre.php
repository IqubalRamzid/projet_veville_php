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

<body>

    <form action="update_membre.php" method="post">

        <div class="form">
            <div class="form-left">

                <input type="number" name="id" id="id" class="d-n" value="<?php echo $resultat['id_membre'] ?>">

                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" value="<?php echo $resultat['pseudo'] ?>">

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?php echo $resultat['nom'] ?>">

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?php echo $resultat['prenom'] ?>">

                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" value="<?php echo $resultat['mdp'] ?>">

            </div>

            <div class="form-right">

                <label for="mail">Email</label>
                <input type="email" name="mail" id="mail" value="<?php echo $resultat['email'] ?>">

                <label for="civilite">Civilité</label>
                <input type="text" name="civilite" id="civilite" value="<?php echo $resultat['civilite'] ?>">

                <label for="statut">Code Postal</label>
                <select name="statut" id="statut">
                    <option value="0" <?php if ($resultat['statut'] == 0) {
                                            echo "selected";
                                        } ?>>Admin</option>
                    <option value="1" <?php if ($resultat['statut'] == 1) {
                                            echo "selected";
                                        } ?>>Membre</option>
                </select>

            </div>

        </div>

        <div class="bouton">
            <input type="submit" value="Enregistrer" class="button">
        </div>



    </form>

</body>

</html>