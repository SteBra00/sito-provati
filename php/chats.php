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
    <title>Provaci.it - Chat</title>
    <script src="https://kit.fontawesome.com/f0d3a88d82.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/general_style.css">
    <link rel="stylesheet" href="../css/chats.css">
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
        <div class="profiles">
            <div class="profile">
                <img class="profile-image" src="../users/pictures/img1.jpeg">
                <h4 class="profile-name">SuperMario99</h4>
            </div>
        </div>

        <div id="chat" class="chat">
            <div class="chat-header">
                <div class="chat-header-left" onclick="openProfile('SuperMario99');">
                    <img class="chat-header-image" src="../users/pictures/img1.jpeg">
                    <h4 class="chat-header-name">SuperMario99</h4>
                </div>
            </div>
            <div class="chat-body">
                <div class="chat-body-message my-message">
                    <p class="chat-body-message-text">Ciao</p>
                    <p class="chat-body-message-time">11:00</p>
                </div>
                <div class="chat-body-message">
                    <p class="chat-body-message-text">Ciao</p>
                    <p class="chat-body-message-time">11:00</p>
                </div>
                <div class="chat-body-message my-message">
                    <p class="chat-body-message-text">Ciao</p>
                    <p class="chat-body-message-time">11:00</p>
                </div>
            </div>
            <div class="chat-footer">
                <div class="chat-footer-left">
                    <button>
                        <i class="fa-solid fa-face-smile"></i>
                    </button>
                    <input type="text" class="chat-footer-input" placeholder="Scrivi qui...">
                </div>
                <div class="chat-footer-right">
                    <button class="chat-send-button">
                        <i class="fa-solid fa-circle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function openProfile(name) {
            window.location.href = "profile.php?name=" + name;
        }
    </script>
</body>
</html>