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

    <main class="form-container">
        <form action="#" method="POST">
            <p class="form-title">Signin</p>
            <input type="text" class="form-input" name="usename" placeholder="Username" required>
            <input type="password" class="form-input" name="password" placeholder="Password" required>
            <input type="submit" class="button-submit" value="Accedi">
            <small>Non hai un account? <a href="signup.php">Registrati</a></small>
        </form>

        <hr class="hr">
        
        <div id="google-signin2" class="button-external-login"></div>
        <script>
            function onSuccess(googleUser) {
                console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
            }

            function onFailure(error) {
                console.log(error);
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