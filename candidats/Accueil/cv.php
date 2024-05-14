<?php 
    session_start();
    $id = $_SESSION['id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    include("../../backend/database.php");
    try {
        $cvReq = "SELECT * FROM cv
                    WHERE id_utilisateur = ?";

        // Préparation et exécution de la première requête
        $getCv = $bdd->prepare($cvReq);
        $getCv->execute(array($id));

        // Récupération des résultats
        $cv = $getCv->fetch(PDO::FETCH_ASSOC);
        if ($cv) {
            header("Location: cv-info.php");
        }else{
            header("Location: cv-form.php");
        }
    }catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
    }
?>