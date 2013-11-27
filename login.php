<?php
session_start();
define("pgr", true);
require_once('includes/site.php');
require_once('includes/configuration.php');
require_once('includes/session.php');
$session = new Session();
$mySession = $session->getSessionData();
$mySession['token'] = rand(50,1500); // Assign a random token, even if not logged in, to help prevent CSRF
if($mySession['authed']) {
	exit('<a href="index.php">You are already logged in.</a>');
}
/*
* Login Page
*/
if($_POST['submit']) {
	$username = $_POST['username'];
	$username = mysql_real_escape_string($username);
	$username = strip_tags($username);
	$username = htmlspecialchars($username, ENT_QUOTES);
	$username = str_replace('exec', '', $username);
	$username = str_replace('eval', '', $username);
	$password = $_POST['password'];
	$password = mysql_real_escape_string($password);
	$password = strip_tags($password);
	$password = htmlspecialchars($password, ENT_QUOTES);
	$password = str_replace('exec', '', $password);
	$password = str_replace('eval', '', $password);
	$query = $db->query('SELECT * FROM users WHERE `user`="'.$username.'"');
	foreach($query as $row) {
		$pass = $row['pass'];
		if($pass == md5($password)) {
			$_SESSION['authed'] = 'yes';
			$_SESSION['username'] = $username;
			exit( 'Logged in.');
		} else {
			
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
	body {
	  padding-top: 40px;
	  padding-bottom: 40px;
	  background-color: #eee;
	}

	.form-signin {
	  max-width: 330px;
	  padding: 15px;
	  margin: 0 auto;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	  margin-bottom: 10px;
	}
	.form-signin .checkbox {
	  font-weight: normal;
	}
	.form-signin .form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
	  -webkit-box-sizing: border-box;
	     -moz-box-sizing: border-box;
	          box-sizing: border-box;
	}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	</style>
    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form method="POST" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="username" id="username" type="text" class="form-control" placeholder="Username" required autofocus>
        <input name="password" id="password" type="password" class="form-control" placeholder="Password" required>
        <input name="submit" value="Sign in" class="btn btn-lg btn-primary btn-block" type="submit">
      </form>

    </div> <!-- /container -->

  </body>
</html>
