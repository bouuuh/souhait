<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</head>
<body>
<div class="body">
    <div class="container ">
        <h1 class='mb-5'>
            Bienvenue sur liste de souhaits
        </h1>
        <?php
        if (empty($_SESSION['prenom'])) {
            ?>
        <div class='text-center'>
            <p>Vous n'êtes pas connecté.</p>
            <p><a href="connexion.php">Se connecter</a> ou <a href='inscription.php'>s'inscrire</a></p>
        </div>
            <?php
        } else {
            echo '<a href="maliste.php">Ma liste</a>';
            echo '<a href="article.php"> Ajouter un article</a>';
            echo "<h3 class='mt-3 mb-3'>Les articles</h3>";
            include('connexionBDD.php');
            $sql = "SELECT * FROM `article`;";
            $query = $db->prepare($sql);
            $query->execute();
            $articles = $query->fetchAll();
    
            if ($_POST) {
                if (!empty($_POST['add'])) {
                $id = $_POST['add'];
                $sql = "INSERT INTO `liste`(`user`, `article`) VALUES (:user,:article)";
                $query = $db->prepare($sql);
                $query->bindValue(':user', $_SESSION['id'], PDO::PARAM_STR);
                $query->bindValue(':article', $_POST['add'], PDO::PARAM_STR);
                $query->execute();
              }
              if (!empty($_POST['supp'])) {
                $id = $_POST['supp'];
                $sql = "DELETE FROM `liste` WHERE `article` = :article AND `user` = :user";
                $query = $db->prepare($sql);
                $query->bindValue(':user', $_SESSION['id'], PDO::PARAM_STR);
                $query->bindValue(':article', $_POST['supp'], PDO::PARAM_STR);
                $query->execute();
              }
            }
            

            if (!empty($articles)) {
                $i= 0;
                foreach ($articles as $article) {
                    
                echo '<div class="card mb-3" style="max-width: 540px; ">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="'.$article["image"].'" class="img-fluid rounded-start" alt="..." style="height:200px; object-fit:cover; width:200px">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">'.$article["nom"].'</h5>
                      <p class="card-text">'.$article["description"].'</p>
                      <p class="card-text"><small class="text-body-secondary">'.$article["prix"].' €</small></p>';
                      $sql = "SELECT * FROM `liste` WHERE `user` = :user AND `article` = :article";
                      $query = $db->prepare($sql);
                      $query->bindValue(':user', $_SESSION['id'], PDO::PARAM_STR);
                      $query->bindValue(':article', $article['id'], PDO::PARAM_STR);
                      $query->execute();
                      $liste = $query->fetch();
                            if (!empty($liste) && $liste['article'] === $article['id']) {
                            echo '<form action="" method="post">
                            <button name="supp" value="'.$article["id"].'" type="submit"><i class="bi bi-heart-fill"></i></button>
                            </form>';
                            } else {
                            echo '<form action="" method="post">
                            <button name="add" value="'.$article["id"].'" type="submit"><i class="bi bi-heart"></i></button>
                            </form>';
                        
                      }
                    
                      echo '</div>
                  </div>
                </div>
              </div>';
            }
            }
        }
        ?>
    </div>
    </div>
</body>
</html>