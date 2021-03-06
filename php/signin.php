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
    <meta name="google-signin-client_id" content="710600571081-ajpq9sbep4u8alvgvpia1a8kf3l1n1vi.apps.googleusercontent.com">
    <title>Provaci.it - Accedi</title>
    <link rel="stylesheet" href="../css/general_style.css">
    <link rel="stylesheet" href="../css/signin.css">
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['isLogged'])) {
            header('location: home.php');
            exit();
        }
    ?>

    <?php
        if($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $mysql = new mysqli('localhost', 'root', '', 'provaci_db');
            if($mysql->connect_errno) {
                echo 'Errore connessione al database';
                exit();
            }
            $result = $mysql->query("SELECT password FROM user WHERE username='$username'");
            if(!$result) {
                echo 'Errore: '.$mysql->error;
                exit();
            }

            $user = $result->fetch_assoc();
            if(!$user) {
                echo 'Utente non trovato';
                exit();
            }
            if(!password_verify($password, $user['password'])) {
                echo 'Password errata';
                exit();
            }

            $_SESSION['isLogged'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            header('location: home.php');
            exit();
        }
    ?>

    <main class="form-container">
        <form action="#" method="POST">
            <p class="form-title">Signin</p>
            <input type="text" class="form-input" name="username" placeholder="Username" required>
            <input type="password" class="form-input" name="password" placeholder="Password" required>
            <input type="submit" class="button-submit" value="Accedi">
            <small>Non hai un account? <a href="signup.php">Registrati</a></small>
        </form>

        <hr class="hr">
        
        <div id="google-signin2" class="button-external-login"></div>
        <script>
            function onSuccess(googleUser) {
                let profile = googleUser.getBasicProfile();
                let name = profile.getName();
                let email = profile.getEmail();
                let picture = profile.getImageUrl();

                /* da controllare */
                $.post('../php/signin.php', {
                    username: email,
                    password: name
                }, function(data) {
                    if(data == 'ok') {
                        window.location.href = 'home.php';
                    } else {
                        alert(data);
                    }
                });
                /* Effettua la richiesta della password (non obbligatoria) */
            }

            function onFailure(error) {
                console.log(error);
                /* Print error */
            }

            function renderButton() {
                gapi.signin2.render('google-signin2', {
                    'scope': 'profile email',
                    'width': 240,
                    'height': 50,
                    'longtitle': true,
                    'theme': 'dark',
                    'onsuccess': onSuccess,
                    'onfailure': onFailure
                });
            }
        </script>
        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    </main>
</body>
</html>
