<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddrecrute";
    
    try {

        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch(PDOException $e) {
        echo "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
    }
?>