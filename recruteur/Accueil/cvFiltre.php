
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les CVs</title>
    <link rel="stylesheet" href="style_prem.css">
    <link rel="stylesheet" href="cvstyle.css">
    <link rel="icon" href="../../img/JOBNET.png" />
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
</head>
<body>
    <div class="nav-container">
        <nav>
            <div class="user">
                <img id="usernavimage" src="../../img/icon_profile.png" alt="user icon">
                <div class="name_id">
                    <div id="nomcomplet"><?php echo"{$_SESSION['Nom']} {$_SESSION['Prenom']}";?></div>
                    <div id="iduser"><label for="id"><?php echo "#{$_SESSION['id']}";?></label></div>
                </div>
            </div>
            <div class="buttons">
                <a href="profile.php"><button>
                    <img src="../../img/icon_profile.png" class="buttonimg">
                    <label for="Profile">Profile</label>
                </button>
                </a>
                <a href="les-annonces.php"><button>
                    <img src="../../img/portfolio.png" class="buttonimg">
                    <label for="Annonces">Annonces</label>
                </button>
                </a>
                <a href="cvs.html"><button id="selected">
                    <img src="../../img/doc.png" class="buttonimg">
                    <label for="Profile">CVs</label>
                </button>
                </a>
                <a href="messagesAcceuil.php"><button>
                    <img src="../../img/chat.png" class="buttonimg">
                    <label for="Profile">Messages</label>
                </button>
                </a>
            </div>
        </nav>
    </div>
    <main>
        <header>
            <form id="form" action="" method="post" name="filtreCv">
                <div class="filtreContain">
                        <div>
                            <label for="domaine">Domaine</label><br>
                            <select name="domaine" id="domaine" name="domaine">
                                <option value="genie info">genie info</option>
                            </select>
                        </div>
                        <div>
                            <label for="ville">Ville</label><br>
                            <select name="ville" id="ville" name="ville">
                                <option value="BERRECHID">BERRECHID</option>
                            </select>
                        </div>
                        <div>
                            <label for="sexe">Sexe</label><br>
                            <select name="sexe" id="sexe">
                                <option value="Male">Male</option>
                            </select>
                        </div>
                        <div>
                            <label for="diplome">Diplome</label><br>
                            <select name="diplome" id="diplome">
                                <option value="LST">LST</option>
                            </select>
                        </div>
                        <div>
                            <label for="Age">Age</label><br>
                            <select name="age" id="age">
                                <option value="21">21</option>
                            </select>
                        </div>
                    </div>
                    <div><p>Definire le score :</p></div>
                    <div class="score">
                            <div>
                                <label for="diplomeScore">Diplome</label>
                                <input type="number" name="diplomeScore">
                            </div>
                            <div>
                                <label for="stageScore">Stage</label>
                                <input type="number" name="stageScore">
                            </div>
                            <div>
                                <label for="experienceScore">Expérience</label>
                                <input type="number" name="experienceScore">
                            </div>
                            <div>
                                <label for="certifScore">Certificats</label>
                                <input type="number" name="certifScore">
                            </div>
                    </div>
                    <button class="btn btn-warning" type="submit" name="filtreCv">Filtrer</button>
                </form>
                <div>
            </header>
                    <?php
                        
                        if (!empty($cvs->cvs)) {
                            foreach ($cvs->cvs as $cv) {
                                $idCandidat= $cv->idCandidat;
                                $nomCandidat= $cv->nom;
                                $prenomCandidat= $cv->prenom;
                                $profession = $cv->infoInstance->profession;
                                $domaine = $cv->infoInstance->domaine;
                                $etablissement = $cv->infoInstance->etablissement;
                                $score= $cv->score;
                                echo'<div class="cvs-container">';
                                    echo '<div class="cv">';
                                        echo '<div class="cv-header">';
                                            echo '<div class="util">';
                                                echo '<img class="profile-icon" src="../../img/icon_profile_black.png" alt="profile-icon" width="50px">';
                                                echo '<div>';
                                                    echo '<p id="nom-utilisateur">' . $nomCandidat . $prenomCandidat . '</p>' ;
                                                    echo '<p id="id">' . '#' . $idCandidat . '</p>';
                                                echo '</div>';
                                            echo '</div>'  ;
                                        echo '<p class="green"><b>' . $profession . '</p>';
                                        echo '</div>';
                                        echo '<div class="cv-info">';
                                            echo '<p><b>Domaine :</b>' . $domaine . '</p>';
                                            echo '<p><b>Etablissement :</b>' . $etablissement . '</p>';
                                        echo '</div>';
                                        echo '<div class="cv-footer">';
                                            echo '<p class="green"><b>Score: </b>' . $score . '</p>';
                                            echo '<button class="detail">Détails</button>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }

                    ?>
                </div>
    </main>
    <script src="cvs.js"></script>
</body>
</html>