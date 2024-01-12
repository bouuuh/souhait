<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');
    session_start();
    if (empty($_SESSION['prenom'])) {
        header("Location: connexion.php");
    }
    if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['image'])) {
   
        $sql = "INSERT INTO `article`(`nom`, `description`, `image`, `prix`) VALUES (:nom,:description,:image,:prix)";
            $query = $db->prepare($sql);
            $query->bindValue(":nom", $_POST["nom"], PDO::PARAM_STR);
            $query->bindValue(":description", $_POST["description"], PDO::PARAM_STR);
            $query->bindValue(":image", $_POST["image"], PDO::PARAM_STR);
            $query->bindValue(":prix", $_POST["prix"], PDO::PARAM_STR);
            $query->execute();
            echo '<div class="alert alert-success" role="alert">
            A simple success alert—check it out!
          </div>';
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout article</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
    <div class="body">
    <div class="container">
        <h2 class="mt-5 mb-3">Ajouter un article</h2>
        <a class="mt-3 mb-3" href="index.php">Retour aux articles</a>
        <form action="" method="post" class="form-control" style="background:#c19875">
            <div class="mb-3">
                <label class="form-label" for="nom">Nom</label>
                <input class="form-control" type="text" name="nom">
            </div>
        
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <input class="form-control" type="text" name="description">
            </div>
            <div class="mb-3">
                <label class="form-label" for="image">Adresse de l'image</label>
                <input class="form-control" type="text" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label" for="prix">Prix</label>
                <input class="form-control" type="text" name="prix">
            </div>
        <button type="submit" class="btn bg-color col-12 mt-3 mb-3">Envoyer</button>
        
    </form>
    </div>
    </div>
</body>
</html>