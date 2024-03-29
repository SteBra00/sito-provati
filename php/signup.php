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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f0d3a88d82.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Provaci.it - Registrati</title>
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
            $name_surname = false;
            if(isset($_POST['name_surname'])) {
                $name_surname = $_POST['name_surname'];
            }
            $email = $_POST['email'];
            $password = $_POST['password'];

            $mysql = new mysqli('localhost', 'root', '', 'provaci_db');
            if($mysql->connect_errno) {
                echo 'Errore connessione al database';
                exit();
            }

            $password = password_hash($password, PASSWORD_DEFAULT);
            $result = $mysql->query("INSERT INTO user (username, name_surname, email, password) VALUES ('$username', '$name_surname', '$email', '$password')");
            if(!$result) {
                echo 'Errore: '.$mysql->error;
                exit();
            }
            
            $_SESSION['isLogged'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            header('location: create_account_data.php');
            exit();
        }
    ?>

    <main class="container">
        <form action="#" method="POST" id="signup-form" onsubmit="return formIsValid();" onchange="checkForm();">
            <div class="input-group has-validation">
                <div class="form-floating is-invalid">
                    <input type="text" class="form-control is-invalid" id="username" name="username" placeholder="MarioRossi123" required>
                    <label for="username">Username</label>
                </div>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
            </div>

            <input type="text" name="name_surname" placeholder="Nome e Cognome*" class="form-input">
            <input type="email" id="email" name="email" placeholder="Email* (esempio@email.it)" class="form-input" required>
            <input type="password" id="password" name="password" placeholder="Password*" minlength="6" class="form-input" required oninput="valutatePassword(this);">
            <div class="password-level-container">
                <hr class="password-level password-level-disabled password-level-left" id="password-low" style="--color: #999999">
                <hr class="password-level password-level-disabled" id="password-medium" style="--color: #ec0000">
                <hr class="password-level password-level-disabled" id="password-hight" style="--color: #ffc400">
                <hr class="password-level password-level-disabled password-level-right" id="password-strong" style="--color: #27ec00">
            </div>
            <input type="password" id="rip_password" placeholder="Conferma Password" class="form-input" required onchange="checkConfirmPassword();">
            <input type="submit" id="submit" value="Avanti">
            
        </form>
        <div id="error-container"></div>
    </main>

    <script>
        var element_low = document.getElementById('password-low');
        var element_medium = document.getElementById('password-medium');
        var element_hight = document.getElementById('password-hight');
        var element_strong = document.getElementById('password-strong');

        lower = false;
        upper = false;
        number = false;
        symbol = false;

        function valutatePassword(element) {
            lower = false;
            upper = false;
            number = false;
            symbol = false;
            
            disableLevel(element_low);
            disableLevel(element_medium);
            disableLevel(element_hight);
            disableLevel(element_strong);

            if(element.value.length>=6) {
                enableLevel(element_low);

                var password = element.value.split('');
                password.forEach(checkCharPassword);

                counter = 0;
                if(lower && upper) counter += 1;
                if(number) counter += 1;
                if(symbol) counter += 1;
                if(element.value.length>10) counter += 1;

                if(counter>1) enableLevel(element_medium);
                if(counter>2) enableLevel(element_hight);
                if(counter>3) enableLevel(element_strong);
            }
        }

        function checkCharPassword(value) {
            if(['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'].includes(value)) {
                number = true;
            } else if(['!', '"', '?', '$', '?', '%', '^', '&', '*', '(', ')',
                        '_', '-', '+', '=', '{', '[', '}', ']', ':', ';', '@',
                        '\'', '~', '#', '|', '\\', ',', '>', '.', '?', '/'].includes(value)) {
                symbol = true;
            } else if(value==value.toLowerCase()) {
                upper = true;
            } else if(value==value.toUpperCase()) {
                lower = true;
            }
        }

        function enableLevel(element) {
            element.classList.remove('password-level-disabled');
        }

        function disableLevel(element) {
            element.classList.add('password-level-disabled');
        }

        function checkConfirmPassword() {
            var password = document.getElementById('password');
            var rip_password = document.getElementById('rip_password');
            
            if(password.value!=rip_password.value) {
                rip_password.classList.add('input-error');
            } else if(rip_password.classList.contains('input-error')) {
                rip_password.classList.remove('input-error');
            }
        }

        function checkForm() {
            let error = $('#error-container');
            error.html('');

            const password = document.getElementById('password');
            const rip_password = document.getElementById('rip_password');
            const username = document.getElementById('username');
            const email = document.getElementById('email');

            $.ajax({
                url: `check_data_signup.php?username=${username.value}&email=${email.value}`,
                success: function(result) {
                    if(result=='1') {
                        error.html('<p class="error">Username o Email già utilizzati</p>');
                    }
                }
            });
            
            if(password.value!=rip_password.value) {
                error.html('<p class="error">Conferma la password</p>');
                rip_password.focus();
            }
        }

        function formIsValid() {
            if($('#error-container').children().length>0) {
                return false;
            } else {
                return true;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>
