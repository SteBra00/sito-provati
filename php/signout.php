<!-- LOGOUT FOR GOOGLE 
<a href="#" onclick="signOut();">Sign out</a>
<script>
	function signOut() {
		var auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then(function () {
			console.log('User signed out.');
		});
	}
</script>
-->
<?php
	session_start();
	if(!isset($_SESSION['isLogged'])) {
		header('location: signin.php');
		exit();
	}

	$_SESSION = [];
	session_destroy();
	header('location: ../index.html');
?>