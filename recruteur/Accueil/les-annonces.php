<?php

session_start();

include("../../backend/database.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Les Annonces</title>
  <link rel="stylesheet" href="style_prem.css" />
  <link rel="stylesheet" href="annonces.css" />
  <link rel="icon" href="../../img/JOBNET.png" />
  <style>
    .required-label::after {
      margin-left: 5px;
      content: "*";
      color: red;
    }
  </style>
</head>

<body>
  <div class="nav-container" style="position: fixed">
    <nav>
      <div class="user">
        <img id="usernavimage" src="../../img/icon_profile.png" alt="user icon" />
        <div class="name_id">
          <div id="nomcomplet">
            <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'] ?>
          </div>
          <div id="iduser">
            <label for="id"><?php echo '#' . $_SESSION['id']; ?></label>
          </div>
        </div>
      </div>
      <div class="buttons">
        <a href="profile.php">
          <button onclick="">
            <img src="../../img/icon_profile.png" class="buttonimg" />
            <label for="Profile">Profile</label>
          </button>
        </a>
        <a href="annoncesPart2.php">
          <button id="selected" onclick="">
            <img src="../../img/portfolio.png" class="buttonimg" />
            <label for="Annonces">Annonces</label>
          </button>
        </a>
        <a href="cvs.php">
          <button onclick="">
            <img src="../../img/doc.png" class="buttonimg" />
            <label for="Profile">CVs</label>
          </button>
        </a>
        <a href="messages.html">
          <button onclick="">
            <img src="../../img/chat.png" class="buttonimg" />
            <label for="Profile">Messages</label>
          </button>
        </a>
      </div>
    </nav>
  </div>

  <main style="
        margin-left: 25%;
        overflow-x: hidden;
        height: 100vh;
        overflow-y: auto;
      ">
    <div>
      <div class="create-announcement-title-container">
        <p>Création de l'annonce</p>
      </div>
      <?php


      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_user = $_SESSION['id'];
        $profil = htmlspecialchars($_POST['profil']);
        $entreprise = htmlspecialchars($_POST['entreprise']);
        $lieu = htmlspecialchars($_POST['place']);
        $type_contrat = htmlspecialchars($_POST['contract']);
        $description = htmlspecialchars($_POST['description']);
        $today_date = date("Y-m-d");

        $statement = $bdd->prepare("INSERT INTO annonce (profil, entreprise, lieu, type_contrat, Description, Date_Pub, IdRecruteur) VALUES (:profil, :entreprise, :lieu, :type_contrat, :description, :today_date, :id_user)");

        $statement->bindParam(':id_user', $id_user);
        $statement->bindParam(':profil', $profil);
        $statement->bindParam(':entreprise', $entreprise);
        $statement->bindParam(':lieu', $lieu);
        $statement->bindParam(':type_contrat', $type_contrat);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':today_date', $today_date);

        if ($statement->execute()) {
          header('Location: annoncesPart2.php');
        } else {
          echo '<div style="display: flex; justify-content: center; color: #6A6A6A">';
          echo "<p>Erreur lors de la publication de l'annonce</p>";
          echo '</div>';
        }
      }

      $bdd = null;
      ?>
      <form id="form" action="les-annonces.php" method="post" name="postAnnounce">
        <div class="create-announcement-container">
          <div class="inputs-container">
            <div class="input-container">
              <p class="input-label required-label">Profil</p>
              <input required name="profil" class="announcement-input" type="text" />
            </div>
            <div class="input-container">
              <p class="input-label required-label">Entreprise</p>
              <input required name="entreprise" class="announcement-input" type="text" />
            </div>
          </div>
          <div class="inputs-container">
            <div class="input-container">
              <p class="input-label required-label">Lieu</p>
              <input required name="place" class="announcement-input" type="text" />
            </div>
            <div class="input-container">
              <p class="input-label required-label">Type de contrat</p>
              <input required name="contract" class="announcement-input" type="text" />
            </div>
          </div>
          <div class="desc-block">
            <p class="input-label required-label">Description</p>
            <textarea required name="description" class="announcement-input" rows="6"></textarea>
          </div>
          <div class="btn-container">
            <button name="postAnnounce" type="submit" id="publié" class="submit-btn">
              Publier
            </button>
          </div>
        </div>
      </form>
    </div>
  </main>
</body>

</html>