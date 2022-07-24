<?php
    if($_GET) {
        $mysql = new mysqli('127.0.0.1', 'root', '', 'provaci_db');
        if($mysql->connect_error) {
            echo 'error';
            exit();
        }

        $username = $_REQUEST['username'];
        $email = $_REQUEST['email'];

        $result = $mysql->query("SELECT id FROM user WHERE username='$username' OR email='$email'");
        if($result) {
            if(mysqli_num_rows($result)==0) {
                echo '0';
                exit();
            }
        }

        echo '1';
    }
?>