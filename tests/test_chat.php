<?php
    session_start();
    if($_GET) {    
        $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> disconected</span><br></div>";
        file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
        session_destroy();
        header("Location: test_chat.php");
    }
    if($_POST) {
        if($_POST['name'] != "") {
            $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        } else {
            echo '<span class="error">Please type in a name</span>';
        }
    }

    function loginForm(){
        echo '<div id="loginform">';
        echo '    <p>Please enter your name to continue!</p>';
        echo '    <form action="test_chat.php" method="post">';
        echo '      <label for="name">Name &mdash;</label>';
        echo '      <input type="text" name="name" id="name" />';
        echo '      <input type="submit" name="enter" id="enter" value="Enter" />';
        echo '    </form>';
        echo '</div>';
    }
?>
 
<!DOCTYPE html>
<html lang="it-IT">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provaci.it</title>
</head>
<body>
    <?php
        if(!isset($_SESSION['name'])) {
            loginForm();
            exit();
        } else {
            $login_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> connected</span><br></div>";
            file_put_contents("log.html", $login_message, FILE_APPEND | LOCK_EX);
        }
    ?>

    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        </div>

        <div id="chatbox">
            <?php
                if(file_exists("log.html") && filesize("log.html") > 0){
                    $contents = file_get_contents("log.html");          
                    echo $contents;
                }
            ?>
        </div>

        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" />
            <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
        </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        // jQuery Document
        $(document).ready(function () {
            $("#submitmsg").click(function () {
                var clientmsg = $("#usermsg").val();
                $.post("post.php", { text: clientmsg });
                $("#usermsg").val("");
                return false;
            });

            function loadLog() {
                var oldscrollHeight = $("#chatbox")[0].scrollHeight-20;

                $.ajax({
                    url: "log.html",
                    cache: false,
                    success: function (html) {
                        $("#chatbox").html(html);

                        var newscrollHeight = $("#chatbox")[0].scrollHeight-20;
                        if(newscrollHeight > oldscrollHeight) {
                            $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
                        }   
                    }
                });
            }

            setInterval(loadLog, 2000);

            $("#exit").click(function () {
                var exit = confirm("Are you sure you want to end the session?");
                if(exit==true) {
                    window.location = "index.php?logout=true";
                }
            });
        });
    </script>
</body>
</html>