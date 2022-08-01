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
    <title>Provaci.it - Home</title>
    <script src="https://kit.fontawesome.com/f0d3a88d82.js" crossorigin="anonymous"></script>
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

        $result = $mysql->query("SELECT * FROM user WHERE username='".$_GET['user']."'");
        $user;
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } elseif($result->num_rows==1) {
            $user = $result->fetch_assoc();
        } else {
            echo 'Errore: rilevati più di un utente con lo stesso username';
            /* DA SEGNALARE AL WEBMASTER */
            exit();
        }

        $result = $mysql->query(
            "SELECT p.name
            FROM (user u LEFT JOIN user_pronoun u_p ON u.id=u_p.user_id) LEFT JOIN pronoun p ON u_p.pronoun_id=p.id
            WHERE u.username='".$_SESSION['username']."'"
        );
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } elseif($result->num_rows==0) {
            unset($user['pronoun']);
        } else {
            $user['pronouns'] = '';
            while($pronoun = $result->fetch_assoc()) {
                $user['pronouns'] .= $pronoun['name'].' - ';
            }
            $user['pronouns'] = substr($user['pronouns'], 0, -3);
        }
        
        $result = $mysql->query("SELECT name FROM gender WHERE id='".$user['gender']."'");
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } elseif($result->num_rows==1) {
            $user['gender'] = $result->fetch_array()[0];
        } else {
            unset($user['gender']);
        }

        $result = $mysql->query("SELECT name FROM orientation WHERE id='".$user['orientation']."'");
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } elseif($result->num_rows==1) {
            $user['orientation'] = $result->fetch_array()[0];
        } else {
            unset($user['orientation']);
        }

        $result = $mysql->query(
            "SELECT r.name AS 'region', p.name AS 'province'
            FROM province p LEFT JOIN region r ON p.region_id=r.id
            WHERE p.id='".$user['province']."'");
        if(!$result) {
            echo 'Errore: '.$mysql->error;
            exit();
        } elseif($result->num_rows==1) {
            $result = $result->fetch_assoc();
            $user['province'] = $result['province'];
            $user['region'] = $result['region'];
        } else {
            unset($user['province']);
            unset($user['region']);
        }
    ?>


    <?php
        if($user['profileDark']==1) {
            echo '<link rel="stylesheet" href="../css/dark_mode.css">';
        } else {
            echo '<link rel="stylesheet" href="../css/light_mode.css">';
        }
    ?>

    <!-- Hai a disposizione un colore primario per ogni utente, salvato nel DB;
        decidi dove utilizzarlo e prelevalo da php tramite $user['profileColor'];
        eventualmente passalo al CSS:
            HTML:
                <p class="myP" style="--profileColor:
                        <php echo $user['profileColor']; >
                ">

            CSS:
                .myP {
                    background: var(--profileColor);
                }
    -->
    
    <nav>
        <a href="home.php">Home</a>
        <a href="chats.php">Chats</a>
        <a href="matching.php">Matching</a>
        <a href="settings.php">Impostazioni</a>
        <a href="signout.php">Signout</a>
    </nav>

    <main>
        <?php
            if($user['verified']==0) {
                echo '<p class="not-verified-popup">Il tuo account non è ancora verificato</p>';
            }
        ?>

        <img class="account-picture" src="
            <?php
                if($user['profilePicture']=='') {
                    echo '../img/default_account_picture.png';
                } else {
                    echo '../users/pictures/'.$user['profilePicture'];
                }
            ?>
        ">

        <p class="username">
            <?php
                echo $user['username'];
            ?>
        </p>

        <?php
            if(isset($user['name_surname'])) {
                echo '<p class="name-surname">'.$user['name_surname'].'</p>';
            }
        ?>

        <?php
            if(isset($user['pronouns'])) {
                echo '<p class="pronouns">'.$user['pronouns'].'</p>';
            }
        ?>

        <?php
            if($user['hideEmail']==0) {
                echo '<p class="email">'.$user['email'].'</p>';
            }
        ?>

        <?php
            if(isset($user['gender'])) {
                echo '<p class="gender">'.$user['gender'].'</p>';
            }
        ?>

        <?php
            if(isset($user['orientation'])) {
                echo '<p class="orientation">'.$user['orientation'].'</p>';
            }
        ?>

        <?php
            if($user['hideBorn']==0 && $user['born']!='') {
                echo '<p class="born">'.$user['born'].'</p>';
            }
        ?>

        <?php
            if($user['biography']!='') {
                echo '<p class="biography">'.$user['biography'].'</p>';
            }
        ?>

        <?php
            if($user['hideNationality']==0 && $user['nationality']!='') {
                echo '<p class="nationality">'.$user['nationality'].'</p>';
            }
        ?>

        <?php
            if($user['hideLocality']==0 && isset($user['region'])) {
                echo '<p class="locality">';
                if(isset($user['province'])) {
                    echo $user['province'].' - ';
                }
                echo $user['region'].'</p>';
            }
        ?>

        <?php
            if($user['profession']!='') {
                echo '<p class="profession">'.$user['profession'].'</p>';
            }
        ?>

        <?php
            if($user['linkInstagram']!='') {
                echo '<a href="'.$user['linkInstagram'].'" class="link-social link-instagram"><i class="fa-brands fa-instagram"></i></a>';
            }
            if($user['linkFacebook']!='') {
                echo '<a href="'.$user['linkFacebook'].'" class="link-social link-facebook"><i class="fa-brands fa-facebook"></i></a>';
            }
            if($user['linkTelegram']!='') {
                echo '<a href="'.$user['linkTelegram'].'" class="link-social link-telegram"><i class="fa-brands fa-telegram"></i></a>';
            }
            if($user['linkSnapchat']!='') {
                echo '<a href="'.$user['linkSnapchat'].'" class="link-social link-snapchat"><i class="fa-brands fa-snapchat"></i></a>';
            }
            if($user['linkTwitter']!='') {
                echo '<a href="'.$user['linkTwitter'].'" class="link-social link-twitter"><i class="fa-brands fa-twitter"></i></a>';
            }
        ?>

        <div class="slideshow-container">
            <?php
                $photography_counter = 0;

                for($i=1;$i<6;$i++) {
                    if($user['photography'.$i]!='') {
                        $photography_counter++;
                        echo '<div class="slide fade">';
                        echo '<img src="../users/photography/'.$user['photography'.$i].'">';
                        echo '</div>';
                    }
                }

                if($photography_counter==0) {
                    echo '<div class="slide fade">';
                    echo '<img src="../img/default_photography.png">';
                    echo '</div>';
                }
            ?>

            <a class="prev" onclick="plusSlides(-1)"><i class="fa-solid fa-angle-left"></i></a>
            <a class="next" onclick="plusSlides(1)"><i class="fa-solid fa-angle-right"></i></a>
        </div>
        <br>

        <div style="text-align:center">
            <?php
                for($i=1;$i<=$photography_counter;$i++) {
                    echo '<span class="dot" onclick="currentSlide('.$i.')"></span>';
                }
            ?>
        </div>
    </main>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("slide");
            let dots = document.getElementsByClassName("dot");

            if(n>slides.length) {
                slideIndex = 1;
            }

            if(n<1) {
                slideIndex = slides.length;
            }

            for(i=0;i<slides.length;i++) {
                slides[i].style.display = "none";
            }

            for(i=0;i<dots.length;i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }
    </script>
    </body>
</html>