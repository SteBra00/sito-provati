<?php
    if($_GET) {
        $nome = $_GET['sender'];
        $msg = $_GET['message'];
        echo "<p><b>$nome</b>: $msg</p>";
    } else {
        die('none');
    }
?>