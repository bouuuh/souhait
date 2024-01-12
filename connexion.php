<?php

include('connexionBDD.php');
    session_start();
    if (!empty($_SESSION['prenom'])) {
        header("Location: index.php");
    }
    if (!empty($_POST['email']) && !empty($_POST['pswd'])) {
   
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();
            $verifEmail = $query->fetch();
        
        if ($verifEmail !== false && $verifEmail['email'] === $_POST['email'] && password_verify($_POST['pswd'], $verifEmail['mdp']) === true) {
            session_destroy();
            session_start();
                $_SESSION['prenom'] = $verifEmail["prenom"];
                $_SESSION['id'] = $verifEmail["id"];
            header("Location: index.php");
   
        }
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
    <div class="body">
    <div class="container">
        <h2 class="mt-5 mb-3">Se connecter</h2>
        <?php 
        if (isset($verifEmail)) {
            if ($verifEmail === false || $verifEmail['email'] !== $_POST['email'] || password_verify($_POST['pswd'], $verifEmail['mdp']) === false) {
                echo '<div class="alert alert-danger" role="alert">
                Vos identifiants sont incorrects.
                </div>';
            }
        }
        
        ?>
        <form action="" method="post" class="form-control" style="background:#c19875">
            <div class="mb-3">
                <label class="form-label" for="email">Entrez votre email</label>
                <input class="form-control" type="email" name="email">
            </div>
        
            <div class="mb-3">
                <label class="form-label" for="pswd">Entrez votre mot de passe</label>
                <input class="form-control" type="password" name="pswd">
            </div>
        <button type="submit" class="btn bg-color col-12 mt-3 mb-3">Envoyer</button>
        <a href="inscription.php" class="mt-4 color">Vous n'avez pas de compte ? Inscrivez-vous.</a>
    </form>
    </div>
    </div>
</body>
</html>