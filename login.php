<?php
session_start();
session_destroy();
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

    <h1>Se connecter</h1>
    <form action="log.php" method="post">

        <div class="form-login">
            <label for="email">Email</label>
            <input type="text" name="email" id="email">

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp">

        </div>

        <div class="bouton">
            <input type="submit" value="Se connecter" class="button">
        </div>

    </form>

</body>

</html>