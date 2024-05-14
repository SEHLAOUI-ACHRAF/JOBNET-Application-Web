<?php

    session_start();

    include("database.php");

    if (isset($_POST["inscripRecruteur"]) || isset($_POST["inscripCandidats"])) {
        
        $nom = htmlspecialchars($_POST["Nom"]);
        $prenom = htmlspecialchars($_POST["Prenom"]);
        $date = ($_POST["Datedenaissance"]);
        $adresse = ($_POST["Adresse"]);
        $telephone = ($_POST["telephone"]);
        $ville = ($_POST["Ville"]);
        $email = ($_POST["Email"]);
        $password_net = $_POST["Password"];
        $password = password_hash($password_net, PASSWORD_DEFAULT);
        $confPassword = $_POST["ConfPassword"];
        $type = $_POST["type"];
        $sexe = $_POST["sexe"];

        try {
            $recupUser = $bdd->prepare("SELECT * FROM utilisateur WHERE email = ?");
            $recupUser->execute([$email]);
            $user = $recupUser->fetch(PDO::FETCH_ASSOC);
    
            if (!$user) {

                try {
            
                    $stmt = $bdd->prepare("INSERT INTO utilisateur (nom, prenom, datenaissance, telephone, ville, adresse, email, password, type, sexe) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute(array($nom, $prenom, $date, $telephone, $ville, $adresse, $email, $password, $type, $sexe));
                    
                    if (isset($_POST["inscripRecruteur"])) {
                        $_SESSION['emailRecruteur'] = $email;
                        header('Location: ../recruteur/Accée/Log-in.html');
                        exit();
                    } else if (isset($_POST["inscripCandidats"])) {
                        $_SESSION['emailCandidat'] = $email;
                        header('Location: ../candidats/Accée/Log-in.html');
                        exit();
                    }
                } catch(PDOException $e) {
                    echo "Une erreur est survenue lors de l'inscription : " . $e->getMessage();
                }

            } else {

                if (isset($_POST["inscripRecruteur"])) {
                    header("Location: ../recruteur/Accée/Inscr.html?message=Email%20déjà%20utilisé");
                    exit();
                } else if(isset($_POST["inscripCandidats"])) {
                    header("Location: ../candidats/Accée/Inscr.html?message=Email%20déjà%20utilisé");
                    exit();
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
        }
        
    } 
?>