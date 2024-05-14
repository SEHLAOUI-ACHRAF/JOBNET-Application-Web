<?php
    session_start();

    include("database.php");

    if (isset($_POST["loginRecruteur"]) || isset($_POST["loginCandidat"])) {
        
        if (!empty($_POST["email"]) && !empty($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            try {
                $recupUser = $bdd->prepare("SELECT * FROM utilisateur WHERE email = ?");
                $recupUser->execute([$email]);
                $user = $recupUser->fetch(PDO::FETCH_ASSOC);
                $password_hash = $user['password'];

                if ($user && password_verify("$password", $password_hash)) {
                    $typeUser = $user['type'];
                    $id_utilisateur=$user['id_utilisateur'];
                    $nomUser= $user['Nom'];
                    $prenomUser= $user['Prenom'];
                    if (isset($_POST["loginRecruteur"]) && $typeUser == "recruteur") {
                        $_SESSION['id']=$id_utilisateur;
                        $_SESSION['nom']=$nomUser;
                        $_SESSION['prenom']=$prenomUser;
                        $_SESSION['emailRecruteur'] = $email;
                        header('Location: ../recruteur/Accueil/accueil.php');
                        exit();
                    } else if (isset($_POST["loginCandidat"]) && $typeUser == "candidat"){
                        $_SESSION['id']=$id_utilisateur;
                        $_SESSION['nom']=$nomUser;
                        $_SESSION['prenom']=$prenomUser;
                        $_SESSION['emailCandidat'] = $email;
                        header('Location: ../candidats/Accueil/accueil.php');
                        exit();
                    }
                    else {
                        if (isset($_POST["loginRecruteur"])) {
                            header("Location: ../recruteur/Accée/Log-in.html?message=Nom+d%27utilisateur+ou+mot+de+passe+incorrect&oq=Nom+d%27utilisateur+ou+mot+de+passe+incorrect");
                            exit();
                        } else if(isset($_POST["loginCandidat"])) {
                            header("Location: ../candidats/Accée/Log-in.html?message=Nom+d%27utilisateur+ou+mot+de+passe+incorrect&oq=Nom+d%27utilisateur+ou+mot+de+passe+incorrect");
                            exit();
                        }
                    }
                } else {

                    if (isset($_POST["loginRecruteur"])) {
                        header("Location: ../recruteur/Accée/Log-in.html?message=Nom+d%27utilisateur+ou+mot+de+passe+incorrect&oq=Nom+d%27utilisateur+ou+mot+de+passe+incorrect");
                        exit();
                    } else if(isset($_POST["loginCandidat"])) {
                        header("Location: ../candidats/Accée/Log-in.html?message=Nom+d%27utilisateur+ou+mot+de+passe+incorrect&oq=Nom+d%27utilisateur+ou+mot+de+passe+incorrect");
                        exit();
                    }
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la récupération des données : " . $e->getMessage();
            }
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }
?>
