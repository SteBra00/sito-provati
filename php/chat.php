<!DOCTYPE html>
<html lang="it-IT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provaci.it - Chat</title>
</head>
<body>
    <!-- controlla se è loggato -->
    <?php
        $mysql = new mysqli('127.0.0.1', 'root', '');
        if($mysql->connect_error) {
            header('HTTP/1.1 500 Internal Server Error');
        }
        
        header('HTTP/1.1 500 Internal Server Error');
    ?>
</body>
</html>