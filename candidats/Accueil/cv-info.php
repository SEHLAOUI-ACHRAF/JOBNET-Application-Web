<?php
    session_start();    
    $id = $_SESSION['id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
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
        <link rel="stylesheet" href="css.css">
        <link rel="icon" href="../../img/JOBNET.png" />
        <link
            href="https://fonts.googleapis.com/css?family=Anton%7CBaskervville%7CRaleway&display=swap"
            rel="stylesheet"
    />
    </head>
    <body onload>
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
                    <a href="cv.php"><button id="selected">
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
            <div id="utilisateur-header">
            <?php
                // Inclure le fichier de connexion à la base de données
                include("../../backend/database.php");

                // Récupérer l'identifiant de l'utilisateur connecté
                $email = $_SESSION['emailCandidat'];
                try {

                    $getUserInfo = $bdd->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ?");
                    $getUserInfo->execute([$email]);
                    $userInfo = $getUserInfo->fetch();

                    if ($userInfo) {
                        $id_utilisateur = $userInfo['id_utilisateur'];
                    } else {
                        echo "User information not found.";
                    }

                } catch (PDOException $e) {
                    echo "Error fetching user information: " . $e->getMessage();
                }

                // Requête SQL pour récupérer le CV de l'utilisateur connecté
                $query_cv = "SELECT * FROM Cv WHERE id_utilisateur = :id_utilisateur";
                $stmt_cv = $bdd->prepare($query_cv);
                $stmt_cv->bindParam(':id_utilisateur', $id_utilisateur);
                $stmt_cv->execute();
                $cv = $stmt_cv->fetch(PDO::FETCH_ASSOC);

                // Vérifier si le CV existe pour cet utilisateur
                if (!$cv) {
                    echo "Aucun CV trouvé pour cet utilisateur.";
                    exit();
                }

                // Récupérer l'ID du CV
                $id_cv = $cv['idCv'];

                // Requête SQL pour récupérer les informations générales du CV
                $query_info = "SELECT * FROM informations WHERE idCv = :id_cv";
                $stmt_info = $bdd->prepare($query_info);
                $stmt_info->bindParam(':id_cv', $id_cv);
                $stmt_info->execute();
                $info = $stmt_info->fetch(PDO::FETCH_ASSOC);

                // Requête SQL pour récupérer les diplômes du CV
                $query_diplomes = "SELECT * FROM diplome WHERE idCv = :id_cv";
                $stmt_diplomes = $bdd->prepare($query_diplomes);
                $stmt_diplomes->bindParam(':id_cv', $id_cv);
                $stmt_diplomes->execute();
                $diplomes = $stmt_diplomes->fetchAll(PDO::FETCH_ASSOC);

                // Requête SQL pour récupérer les stages du CV
                $query_stages = "SELECT * FROM stage WHERE idCv = :id_cv";
                $stmt_stages = $bdd->prepare($query_stages);
                $stmt_stages->bindParam(':id_cv', $id_cv);
                $stmt_stages->execute();
                $stages = $stmt_stages->fetchAll(PDO::FETCH_ASSOC);

                // Requête SQL pour récupérer les expériences professionnelles du CV
                $query_experiences = "SELECT * FROM experPro WHERE idCv = :id_cv";
                $stmt_experiences = $bdd->prepare($query_experiences);
                $stmt_experiences->bindParam(':id_cv', $id_cv);
                $stmt_experiences->execute();
                $experiences = $stmt_experiences->fetchAll(PDO::FETCH_ASSOC);

                // Requête SQL pour récupérer les certificats du CV
                $query_certificats = "SELECT * FROM certificats WHERE idCv = :id_cv";
                $stmt_certificats = $bdd->prepare($query_certificats);
                $stmt_certificats->bindParam(':id_cv', $id_cv);
                $stmt_certificats->execute();
                $certificats = $stmt_certificats->fetchAll(PDO::FETCH_ASSOC);

                // Requête SQL pour récupérer les autres informations du CV
                $query_autres = "SELECT * FROM autre WHERE idCv = :id_cv";
                $stmt_autres = $bdd->prepare($query_autres);
                $stmt_autres->bindParam(':id_cv', $id_cv);
                $stmt_autres->execute();
                $autres = $stmt_autres->fetchAll(PDO::FETCH_ASSOC);

                // Affichage des informations du CV
                echo "<h1>Informations du CV</h1>";
                echo "<h2>Informations générales</h2>";
                echo "<p>Profession: " . $info['profession'] . "</p>";
                echo "<p>Domaine: " . $info['domaine'] . "</p>";
                echo "<p>Etablissement: " . $info['etablissement'] . "</p>";

                // Affichage des diplômes
                echo "<h2>Diplômes</h2>";
                foreach ($diplomes as $diplome) {
                    echo "<p>Nom du diplôme: " . $diplome['diplomeName'] . "</p>";
                    echo "<p>Durée: " . $diplome['diplomeDuree'] . "</p>";
                }

                // Affichage des stages
                echo "<h2>Stages</h2>";
                foreach ($stages as $stage) {
                    echo "<p>Nom du stage: " . $stage['nomStage'] . "</p>";
                    echo "<p>Durée: " . $stage['stageDuree'] . "</p>";
                    echo "<p>Entreprise: " . $stage['entrepriseStage'] . "</p>";
                    echo "<p>Sujet: " . $stage['sujet'] . "</p>";
                }

                // Affichage des expériences professionnelles
                echo "<h2>Expériences professionnelles</h2>";
                foreach ($experiences as $experience) {
                    echo "<p>Poste: " . $experience['poste'] . "</p>";
                    echo "<p>Durée: " . $experience['dureeEx'] . "</p>";
                    echo "<p>Entreprise: " . $experience['entrepriseExp'] . "</p>";
                }

                // Affichage des certificats
                echo "<h2>Certificats</h2>";
                foreach ($certificats as $certificat) {
                    echo "<p>Nom du certificat: " . $certificat['certifNom'] . "</p>";
                }

                // Affichage des autres informations
                echo "<h2>Autres informations</h2>";
                foreach ($autres as $autre) {
                    echo "<p>Intérêt: " . $autre['interet'] . "</p>";
                }


            ?>
            </div>
        <button type="button" class="btn btn-danger" id="nouveauCv">Nouveau CV</button>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
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
        <script src="cv.js"></script>
        <script>
            function nouveauCvAlert() {
                var confirmation = confirm("Êtes-vous sûr de vouloir de crée un autre CV ? votre cv actuelle va étre perdu\n  *Cette action est irréversible.");
                
                if (confirmation) {
                    alert("Vous avez choisi de crée un autre CV.");
                    window.location.href = "cv-form.php";
                } else {
                    alert("Vous avez choisi de rester sur la page.");
                    // Ajoutez ici le code à exécuter si l'utilisateur choisit de rester sur la page
                }
            }
        const nouveauCvBtn = document.getElementById("nouveauCv");
        nouveauCvBtn.addEventListener('click', function(event) {
        nouveauCvAlert();
        });
        </script>
    </body>
</html>
