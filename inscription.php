<?php

session_start();
include('connexionBDD.php');
    
    
if (!empty($_SESSION['prenom'])) {
    header("Location: index.php");
}

    if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['pswd'])) {
   
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();
            $verifEmail = $query->fetch();

            if ($verifEmail === false) {
                $sql = "INSERT INTO `user` (`nom`, `prenom`, `email`, `mdp`) 
                VALUES (:nom, :prenom, :email, :mdp)";
                $query = $db->prepare($sql);
                $query->bindValue(":nom", $_POST['name'], PDO::PARAM_STR);
                $query->bindValue(":prenom", $_POST['surname'], PDO::PARAM_STR);
                $query->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
                $hash = password_hash($_POST['pswd'], PASSWORD_DEFAULT);
                $query->bindValue(":mdp", $hash, PDO::PARAM_STR);
                $query->execute();
            }
        

    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
<div class='body'>
    <div class="container">
        <h2 class="mt-5 mb-3">S'inscrire</h2>
        <?php 
        if (isset($verifEmail) && $verifEmail !== false) {
           echo '<div class="alert alert-danger" role="alert">
            Vous avez déjà un compte.
            </div>';
        }
        
        ?>
        <form action="" method="post" class="form-control" style="background:#c19875">
            <div class="mb-3">
                <label class="form-label" for="name">Entrez votre nom</label>
                <input class="form-control" type="text" name='name'>
            </div>
        
            <div class="mb-3">
               <label class="form-label" for="surname">Entrez votre prénom</label>
                <input class="form-control" type="text" name="surname"> 
            </div>
        
            <div class="mb-3">
                <label class="form-label" for="email">Entrez votre email</label>
                <input class="form-control" type="email" name="email">
            </div>
        
            <div class="mb-3">
                <label class="form-label" for="pswd">Entrez votre mot de passe</label>
                <input class="form-control" type="password" name="pswd">
            </div>


        <button type="submit" class="btn bg-color col-12 mt-3 mb-3">Envoyer</button>
        <a href="connexion.php" class="mt-4 color">Vous avez un compte ? Connectez-vous.</a>
    </form>
    </div>
    </div>
</body>
</html>