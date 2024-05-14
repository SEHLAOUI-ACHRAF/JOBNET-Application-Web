<?php
session_start();

include("../../backend/database.php");

$email = $_SESSION['emailCandidat'];

try {

    $getUserInfo = $bdd->prepare("SELECT id_utilisateur, Nom, Prenom FROM utilisateur WHERE email = ?");
    $getUserInfo->execute([$email]);
    $userInfo = $getUserInfo->fetch();

    if ($userInfo) {

        $id = $userInfo['id_utilisateur'];
        $nom = $userInfo['Nom'];
        $prenom = $userInfo['Prenom'];

        include("accueil.html");
        
    } else {

        echo "User information not found.";
    }
} catch (PDOException $e) {
    echo "Error fetching user information: " . $e->getMessage();
}
?>
