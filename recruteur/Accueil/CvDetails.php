<?php
    
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Mon CV</title>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="../../recruteur/Accueil/style_prem.css">
        <link rel="stylesheet" href="cvsstyle.css">
        <link rel="icon" href="../../img/JOBNET.png" />
        <link
            href="https://fonts.googleapis.com/css?family=Anton%7CBaskervville%7CRaleway&display=swap"
            rel="stylesheet"
    />
    </head>
    <body>
        <div class="nav-container">
            <nav>
                <div class="user">
                    <img id="usernavimage" src="../../img/icon_profile.png" alt="user icon">
                    <div class="name_id">
                        <div id="nomcomplet"><?php echo"{$nom} {$prenom}";?></div>
                        <div id="iduser"><label for="id"><?php echo "#{$id}";?></label></div>
                    </div>
                </div>
                <div class="buttons">
                    <a href="profile.php"><button>
                        <img src="../../img/icon_profile.png" class="buttonimg">
                        <label for="Profile">Profile</label>
                    </button>
                    </a>
                    <a href="annoncesPart2.php">
                        <button>
                        <img src="../../img/portfolio.png" class="buttonimg">
                        <label for="Annonces">Les offres</label>
                    </button>
                    </a>
                    <a href="cvs.html"><button id="selected">
                        <img src="../../img/doc.png" class="buttonimg">
                        <label for="Profile">mon CV</label>
                    </button>
                    </a>
                    <a href="messages.html"><button>
                        <img src="../../img/chat.png" class="buttonimg">
                        <label for="Profile">Messages</label>
                    </button>
                    </a>
                </div>
            </nav>
        </div>
        <main>
            <div class="utilisateur-header">
                <div>
                    <img class="profile-icon" src="../../img/icon_profile_black.png" alt="profile-icon">
                <div>
                    <h2 id="nom-utilisateur"><?php echo"{$nom} {$prenom}";?></h2>
                    <p id="id"><?php echo "#{$id}";?></p>
                </div>
                </div>
            </div>
            <div class="container">
                <div id="titre">
                    <h2>Voici les informations de votre CV</h2>
                </div>
                <div>
                    <div>
                        <h3>Informations personnels</h3><br>
                        <p><b>Profession :</b><?php echo $CV->infoInstance->profession; ?></p><br>
                        <p><b>Domaine :</b><?php echo $CV->infoInstance->domaine; ?></p><br>
                        <p><b>Etablissement :</b><?php echo $CV->infoInstance->etablissement; ?></p><br>
                    </div>
                    <div>
                        <h3>Diplomes</h3><br>
                        <?php
                            foreach ($CV->diplomes as $diplome){
                                echo "<p><b>Nom: </b> $diplome->nom</p>";
                                echo "<p><b>Durée: </b> $diplome->duree</p>";
                            }
                        ?>
                    </div>
                    <div>
                        <h3>Stage</h3>
                        <?php
                            foreach ($CV->stages as $stage){
                                echo "<p><b>Nom: </b> $stage->nom</p>";
                                echo "<p><b>Durée: </b> $stage->duree</p>";
                                echo "<p><b>Entreprise: </b> $stage->entreprise</p>";
                                echo "<p><b>Sujet: </b> $stage->sujet</p>";
                        }
                        ?>
                    </div>
                    <div>
                        <h3>Expériences professionels</h3>
                        <?php
                            foreach ($CV->experiencesPro as $experiencePro){
                                echo "<p><b>Poste: </b> $experiencePro->poste</p>";
                                echo "<p><b>Durée: </b> $experiencePro->duree</p>";
                                echo "<p><b>Entreprise: </b> $experiencePro->entreprise</p>";
                        }
                        ?>
                    </div>
                    <div>
                        <h3>Certificats</h3>
                        <?php
                            foreach ($CV->certificats as $certificat){
                                echo "<p><b>Nom: </b> $certificat->nom</p>";
                            }
                        ?>
                    </div>
                    <div>
                        <h3>Autre </h3>
                        <?php
                            foreach ($CV->autres as $autre){
                                echo "<p><b>Interet: </b> $autre->interet</p>";
                            }
                        ?>
                    </div>  
                </div>

            </div>
        <button type="button" class="btn btn-submit">Contacter</button>
        </main>
        
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        <script src="cvs.js"></script>
    </body>
</html>
