<?php

include "AdminDAO.php";
include "MemberDAO.php";
include "MembershipDAO.php";
include "HouseholdDAO.php";

/**
 * TODO: Database connection pooling. Look into mysql_pconnect()
 */
function getConnection() {
  include "password.php";
  $con = mysql_connect("localhost", "tulsahub", $dbpassword);
  mysql_select_db("tulsahub", $con) or die("Could not select database.");
  return $con;
}

function getDao($vo) {
  $con = getConnection();
  switch ($vo) {
    case "admin":
      return new AdminDAO($con);
    case "member":
      return new MemberDAO($con);
    case "membership":
      return new MembershipDAO($con);
	case "household":
		return new HouseholdDAO($con);
  }
}
