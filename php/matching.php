<!DOCTYPE html>
<html lang="it-IT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#eb0e45">
    <meta property="og:title" content="Provaci.it">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://127.0.0.1/SitoProvaci/">
    <meta property="og:image" content="../img/og-icon.jpeg">
    <title>Provaci.it - Matching</title>
    <script src="https://kit.fontawesome.com/f0d3a88d82.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/general_style.css">
    <link rel="stylesheet" href="../css/matching.css">
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION['isLogged'])) {
            header('location: signin.php');
            exit();
        }
    ?>

    <nav>
        <a href="home.php">Home</a>
        <a href="chats.php">Chats</a>
        <a href="#">Matching</a>
        <a href="settings.php">Impostazioni</a>
        <a href="signout.php">Signout</a>
    </nav>

    <main>
    <!-- Questi bottoni sono eccessivamente grandi, trova una misura più adatta -->
    <?php
        $mysql = new mysqli('localhost', 'root', '', 'provaci_db');
        if($mysql->connect_errno) {
            echo 'Errore connessione al database';
            exit();
        }

        $result = $mysql->query("SELECT userTo_id, compatibility FROM matched WHERE userFrom_id=(SELECT id FROM user WHERE username='".$_SESSION['username']."')");
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } else {
            while($row = $result->fetch_assoc()) {
                $user = $mysql->query("SELECT username, name_surname, gender, orientation, born, profilePicture FROM user WHERE id='".$row['userTo_id']."'");
                if(!$user) {
                    echo 'Errore: '.$mysql->error;
                    exit();
                } else {
                    $user = $user->fetch_assoc();
                    echo '<div class="modal-button" onclick="openModal(modal_'.$user['username'].');">';
                    if($user['profilePicture']=='') {
                        echo '<img class="modal-button-image" src="../img/default_account_picture.png" alt="'.$user['username'].'">';
                    } else {
                        echo '<img class="modal-button-image" src="../users/pictures/'.$user['profilePicture'].'" alt="'.$user['username'].'">';
                    }
                    echo '<div class="modal-button-text">';
                    echo '<p class="modal-button-text-username">'.$user['username'].'</p>';
                    echo '<p class="modal-button-text-compatibility">Compatibilità: '.$row['compatibility'].'</p>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div id="modal_'.$user['username'].'" class="modal">';
                    echo '<span class="close" onclick="closeModal(modal_'.$user['username'].');">';
                    echo '<i class="fa-solid fa-times"></i>';
                    echo '</span>';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-left">';
                    if($user['profilePicture']=='') {
                        echo '<img class="modal-left-image" src="../img/default_account_picture.png" alt="'.$user['username'].'">';
                    } else {
                        echo '<img class="modal-left-image" src="../users/pictures/'.$user['profilePicture'].'" alt="'.$user['username'].'">';
                    }
                    echo '</div>';
                    echo '<div class="modal-right">';
                    echo '<div class="modal-right-text">';
                    echo '<p><label>Username: </label>'.$user['username'].'</p>';
                    echo '</div>';
                    echo '<div class="modal-right-text">';
                    echo '<p><label>Nome e Cognome: </label>'.$user['name_surname'].'</p>';
                    echo '</div>';

                    if($user['born']!='') {
                        $user['born'] = '<i class="fa-regular fa-question"></i>';
                    }
                    echo '<div class="modal-right-text">';
                    echo '<p><label>Nascita: </label>'.$user['born'].'</p>';
                    echo '</div>';

                    if($user['gender']!='') {
                        $gender = $mysql->query("SELECT name FROM gender WHERE id='".$user['gender']."'");
                        if(!$gender) {
                            $gender = '<i class="fa-regular fa-question"></i>';
                        } else {
                            $gender = $gender->fetch_assoc()['name'];
                        }
                        echo '<div class="modal-right-text">';
                        echo "<p><label>Genere: </label>$gender</p>";
                        echo '</div>';
                    }

                    if($user['orientation']!='') {
                        $orientation = $mysql->query("SELECT name FROM orientation WHERE id='".$user['orientation']."'");
                        if(!$orientation) {
                            $orientation = '<i class="fa-regular fa-question"></i>';
                        } else {
                            $orientation = $orientation->fetch_assoc()['name'];
                        }
                        echo '<div class="modal-right-text">';
                        echo "<p><label>Orientamento: </label>$orientation</p>";
                        echo '</div>';
                    }

                    echo '<div class="modal-right-buttons">';
                    echo '<div class="tooltip">';
                    echo '<a href="profile.php?user='.$user['username'].'"><i class="fa-regular fa-user"></i></a>';
                    echo '<span class="tooltiptext">Visualizza Profilo</span>';
                    echo '</div>';
                    echo '<div class="tooltip">';
                    echo '<a href="chat.php?user='.$user['username'].'"><i class="fa-solid fa-message"></i></a>';
                    echo '<span class="tooltiptext">Apri Chat</span>';
                    echo '</div>';
                    echo '<div class="tooltip">';
                    echo '<a href="block.php?user='.$user['username'].'"><i class="fa-solid fa-flag"></i></a>';
                    echo '<span class="tooltiptext">Blocca Profilo</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
    ?>
    </main>

    <script>
        function openModal(element) {
            element.style.display = "block";
        }

        function closeModal(element) {
            element.style.display = "none";
        }

        window.onclick = function(event) {
            var element = event.target;
            if(element.classList.contains('modal')) {
                element.style.display = "none";
            }
        }
    </script>
</body>
</html>