<?php

    session_start();

    include("../../backend/database.php");

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $getid = $_GET['id'];
        $recupUsers = $bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
        $recupUsers->execute(array($getid));
        $users = $recupUsers->fetch();
        if ($users) {
            if (isset($_POST["envoyer"])) {
                if (!empty($_POST["message"])) {
                    $message = htmlspecialchars($_POST["message"]);
                    $insertmsg = $bdd->prepare("INSERT INTO message (contenu , receiver, sender) VALUES (?, ?, ?)");
                    $insertmsg->execute(array($message, $getid, $_SESSION['id']));
                }
            }
        } else {
            echo "Aucun utilisateur trouvé";
        }
    } else {
        echo "Aucun ID trouvé";
    }

    $sql = "SELECT id_utilisateur, Nom, Prenom FROM utilisateur WHERE email = ?";
    $result = $bdd->prepare($sql);
    $result->execute(array($_SESSION['emailRecruteur']));
    $user = $result->fetch();
    $nomcomplet = $user["Nom"] . " " . $user["Prenom"];
    $id = $user["id_utilisateur"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="../../recruteur/Accueil/style_prem.css">
    <link rel="stylesheet" href="messages.css">
    <link rel="icon" href="../../img/JOBNET.png" />
</head>
<body>
    <div class="nav-container">
        <nav>
            <div class="user">
                <img id="usernavimage" src="../../img/icon_profile.png" alt="user icon">
                <div class="name_id">
                    <div id="nomcomplet"> <?php echo $nomcomplet; ?></div>
                    <div id="iduser"><label for="id"><?php echo "#{$id}";?></label></div>
                </div>
            </div>
            <div class="buttons">
                <a href="profile.php"><button>
                    <img src="../../img/icon_profile.png" class="buttonimg">
                    <label for="Profile">Profile</label>
                </button></a>
                <a href="annoncesPart2.php">
                    <button>
                    <img src="../../img/portfolio.png" class="buttonimg">
                    <label for="Annonces">Annonces</label>
                </button></a>
                <a href="cvs.php"><button>
                    <img src="../../img/doc.png" class="buttonimg">
                    <label for="Profile">CVs</label>
                </button></a>
                <a href="messagesAcceuil.php"><button id="selected">
                    <img src="../../img/chat.png" class="buttonimg">
                    <label for="Profile">Messages</label>
                </button></a>
            </div>
        </nav>
    </div>
<main>
    <div>
       <div id="l">
            <div id="msg"><label><b>Messages</b></label></div>
            <div id="users">
                <?php
                    $recupUsers = $bdd->query("SELECT * FROM utilisateur");
                    while ($user = $recupUsers->fetch()) {
                        if($user['email'] != $_SESSION['emailRecruteur']) {
                        ?>
                        <a href="messagesPrive.php?id=<?php echo $user['id_utilisateur'] ?>">
                        <p id="userBlock"><?php echo $user['Nom'] . ' ' . $user['Prenom']; ?></p>
                        </a>
                        <?php
                        }
                    }
                ?>                   
            </div>
        </div>
        <div id="r">
            <div id="userInfo">
                <img id="imguser" src="../../img/icon_profile_black.png" alt="user icon">
                <div class="name_id">
                    <div id="nomcomplet"><?php echo $nomcomplet; ?></div>
                </div>
                <p id="userProfile"></p>
            </div>
            <div id="Conversations">
                <section id="messages">
                    <?php
                        if (isset($getid)) {
                            $recupMsg = $bdd->prepare("SELECT m.contenu, m.sender, m.receiver, u.Nom, u.Prenom FROM message m INNER JOIN utilisateur u ON m.sender = u.id_utilisateur WHERE (m.sender=? AND m.receiver=?) OR (m.sender=? AND m.receiver=?) ORDER BY m.id;");
                            $recupMsg->execute(array($_SESSION['id'], $getid, $getid, $_SESSION['id']));
                            while ($msg = $recupMsg->fetch()) {
                                $isCurrentUserSender = $msg['sender'] == $_SESSION['id'];
                                $senderName = $isCurrentUserSender ? $nomcomplet : htmlspecialchars($msg['Nom']) . ' ' . htmlspecialchars($msg['Prenom']);
                                $receiverName = $isCurrentUserSender ? htmlspecialchars($msg['Nom']) . ' ' . htmlspecialchars($msg['Prenom']) : $nomcomplet;
                                $messageColor = $isCurrentUserSender ? 'blue' : 'red';
                                $messageClass = $isCurrentUserSender ? 'sent' : 'received';
                                ?>
                                <p id="msgs" class="<?= $messageClass; ?>">
                                    <span id="msguser" style="color: <?= $messageColor; ?>">
                                        <?= $senderName; ?>:
                                    </span>
                                    <?= htmlspecialchars($msg['contenu']); ?>
                                </p>
                                <?php
                            }                                
                        }
                        ?>
                    </section>                                
            </div>
            <div id="Envoyer">
                <form method="post" action="">
                    <textarea id="messageb" name="message"></textarea>
                    <input id="envoyerb" type="submit" value="envoyer" name="envoyer">
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>

