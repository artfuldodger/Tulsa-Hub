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
	<div id="contentContainer">



		<div id="login">

			<div id="header">
				<h3>
					Hey, welcome to the Login. You know what to do...
				</h3>

			</div>


			<div id="l1">

			   <fieldset>

				   <form action="/index.php" method="post">
						<label for="username">
							Username:
						</label>
						<input type="text" name="username" id="username" value="" />
						<br>
						<br>
						<label for="password">
							Password:
						</label>
						<input type="password" name="password" id="password" value="" />
						<br>
						<br>
						<br>
                        <input type="hidden" name="login" value="true" />
						<button>
						  <span>Login</span>
						</button>
					</form>
			   </fieldset>


			</div>


			<div id="message">

			   <fieldset>
					<legend>
							Looking for the Tulsa Hub home page?
					</legend>
					<a href="http://www.tulsahub.org" title="Link to Tulsa Hub site">
						<img src="images/hubSite.jpg" alt="Tulsa Hub site image" width="198" height="146" />
					</a>
				</fieldset>
			</div>





		</div>




	</div>

    
<?
  } // end showing form (when you're not logged in)
?>
</body>
</html>
