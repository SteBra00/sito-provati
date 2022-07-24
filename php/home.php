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

    <main>

    </main>
</body>
</html>