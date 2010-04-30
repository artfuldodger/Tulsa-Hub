<?php
include "vo/AdminVO.php";
session_start();
include "dao/FactoryDAO.php";
include "inc/utils.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tulsa Hub - Membership</title>
<link rel="stylesheet" type="text/css" href="inc/styles.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>
<body>

<?php

  if (isset($_GET["logout"])) {
    $_SESSION["logout"] = true;
    $_SESSION["admin"] = null;
    session_destroy();

    echo '<p>You have logged out. Come back soon!</p>';
  }
  else if (isset($_POST["login"])) {

    $dao = getDao("admin");
    $user = $dao->authenticate($_POST["username"], $_POST["password"]);
    if ($user == null) {
      echo '<p class="error">Invalid username or password. Please try again!</p>';
    } else {
      $_SESSION["admin"] = $user;
      $_SESSION["logout"] = false;
    }
  }

  if (logged_in()) {
    echo '<p>You are logged in as ',$_SESSION["admin"]->getUsername(),' (',$_SESSION["admin"]->getDisplayName(),') [<a href="/index.php?logout=yes">logout</a>]</p>';
	
	include("members.php");
  } else {
?>
  <h1>Looking for the Tulsa Hub home page? <a href="http://www.tulsahub.org">It's over here.</a></h1>


  <form action="/index.php" method="post">
      <table>
          <tr>
              <td><label for="username">Username:</label></td>
                <td><input type="text" name="username" id="username" value="<?php echo $_POST["username"]; ?>" /></td>
            </tr>
            <tr>
              <td><label for="password">Password:</label></td>
                <td><input type="password" name="password" id="password" value="<?php echo $_POST["password"]; ?>" /></td>
            </tr>
            <tr>
              <td colspan="2">
                  <input type="submit" value="Log in" name="login" class="large red awesome" />
                </td>
            </tr>
         </table>
    </form>
    
<?
  } // end showing form (when you're not logged in)
?>
</body>
</html>
