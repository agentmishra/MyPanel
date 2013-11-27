<?php
session_start();
define("pgr", true);
require_once('includes/site.php');
require_once('includes/configuration.php');
require_once('includes/session.php');
$session = new Session();
$mySession = $session->getSessionData();
$mySession['token'] = rand(50,1500); // Assign a random token, even if not logged in, to help prevent CSRF
if(!$mySession['authed']) {
	exit('<a href="login.php">Please login, first.</a>');
}
/*
* Index/Home Page
*/
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $brand_sitename; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/fontend.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo $brand_sitename; ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class=""><a href="index.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="well">
            <h2>MySQL Information</h2>
            <p>Username: <?php echo $mySession['username']; ?><br>Password: <b>your account password</b>
              <br>
              phpMyAdmin: <a href="<?php echo $site_url; ?>phpMyAdmin">Click here</a></p>
          </div>
          <br>
          <div class="well">
            <h2>Create MySQL Database</h2>
            <p>
              <?php
                if($_POST['create_db']) {
                  $dbn = mysql_real_escape_string($_POST['dbname']);
                  $dbn = strip_tags($dbn);
                  $dbn = htmlspecialchars($dbn, ENT_QUOTES);
                  $dbu = mysql_real_escape_string($_POST['dbuser']);
                  $dbu = strip_tags($dbn);
                  $dbu = htmlspecialchars($dbn, ENT_QUOTES);
                  $dbp = mysql_real_escape_string($_POST['dbpass']);
                  $dbp = strip_tags($dbn);
                  $dbp = htmlspecialchars($dbn, ENT_QUOTES);
                  $cur = mysql_real_escape_string($_POST['currentpass']);
                  $cur = strip_tags($cur);
                  $cur = htmlspecialchars($cur, ENT_QUOTES);
                  // login and create database
                  try {
                    $dbh = new PDO("mysql:host=localhost", $mySession['username'], $cur);
                    $dbh->exec("CREATE DATABASE `$dbn`;
                                CREATE USER '$dbu'@'localhost' IDENTIFIED BY '$dbp';
                                GRANT ALL ON `$dbn`.* TO '$dbu'@'localhost';
                                FLUSH PRIVILEGES;")
                    or die(print_r($dbh->errorInfo(), true));
                    echo 'Created database '.$dbn;
                  } catch(PDOException $e) {
                    die("DB Error: ".$e->getMessage());
                  }
                } else {
                  ?>
                    <form method="POST">
                      <b>Current MySQL account password: </b> <input type='password' name='currentpass' value=''><br>
                      Database Name: <?php echo $mySession['username']; ?>_<input type='text' name='dbname' value=''><br>
                      Database User: <?php echo $mySession['username']; ?>_<input type='text' name='dbuser' value=''><br>
                      Database Pass: <?php echo $mySession['username']; ?>_<input type='text' name='dbpass' value=''><br>
                      <input class="btn btn-success btn-small" type="submit" name="create_db" value="Create Database">
                    </form>
                  <?php
                }
              ?>
            </p>
          </div>
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="list-group">
            <a href="index.php" class="list-group-item">Home</a>
            <a href="ssh.php" class="list-group-item">Console</a>
            <a href="mysql.php" class="list-group-item active">MySQL</a>
            <a href="ftp.php" class="list-group-item">FTP</a>
            <a href="filemanager.php" class="list-group-item">File Manager</a>
            <a href="domain.php" class="list-group-item">Domain Manager</a>
            <a href="logout.php" class="list-group-item">Logout</a>
          </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; <?php echo $brand_sitename; ?></p>
      </footer>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/canvas.js"></script>
  </body>
</html>
