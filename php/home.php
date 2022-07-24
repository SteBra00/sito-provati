<!DOCTYPE html>
<html lang="it-IT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#eb0e45">
    <meta property="og:title" content="Provaci.it">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://127.0.0.1/SitoProvaci/">
    <meta property="og:image" content="img/og-icon.jpeg">
    <title>Provaci.it - Home</title>
    <link rel="stylesheet" href="../css/general_style.css">
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION['isLogged'])) {
            header('location: signin.php');
            exit();
        }
    ?>

    <?php
        $mysql = new mysqli('localhost', 'root', '', 'provaci_db');
        if($mysql->connect_errno) {
            echo 'Errore connessione al database';
            exit();
        }

        $result = $mysql->query("SELECT * FROM user WHERE username='".$_SESSION['username']."'");
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } elseif($result->num_rows==1) {
            $user = $result->fetch_assoc();
        } else {
            echo 'Errore';
            echo $_SESSION['username'];
            exit();
        }
    ?>

    <nav>
        <form action="search.php" method="GET">
            <input type="search" name="text" placeholder="Cerca" required>
            <input type="submit" value="Vai">
        </form>
        <a href="chats.php">Chats</a>
        <a href="search.php">Cerca</a>
        <a href="matching.php">Matching</a>
        <a href="settings.php">Impostazioni</a>
        <a href="signout.php">Signout</a>
    </nav>

    <main>
        <img class="account-picture" src="
            <?php
                if($user['profilePicture']=='') {
                    echo '../img/default_account_picture.png';
                } else {
                    echo '../users/pictures/'.$user['profilePicture'];
                }
            ?>
        ">
    </main>
</body>
</html>