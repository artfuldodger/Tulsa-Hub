<?php

class MemberDAO {
  var $conn;

  function UserDAO(&$conn) {
    $this->conn =& $conn;
  }

	function save(&$vo) {
		echo '<p>Calling save for ',$vo->toString(),'</p>';
		if ($vo->getId() == 0) {
			$id = $this->insert($vo);
			$vo->setId($id);
		} else {
			$this->update($vo);
		}
	}
 
//  ($idIn = 0, $firstNameIn = "", $lastNameIn = "", $emailIn = "", $phoneIn = "", $preferredContactIn = "", $volunteerContactIn = "", $membershipTypeIn = "", $signUpIn = "")


  function getUserFromResult($result) {
    $row = mysql_fetch_assoc($result);
    return $this->getUserFromRow($row);
  }
  
  function getUserFromRow($row) {
	return new MemberVO($row["id"], $row["first_name"], $row["last_name"], $row["email"], $row["phone"], $row["preferred_contact"], $row["volunteer_contact"], $row["membership_type"], $row["sign_up"]);
  }

  function get($id) {
    $id = $id + 0; // force into int
    $query = "SELECT * FROM member WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    if (!$result) {
      return null;
    }
    return $this->getUserFromResult($result);
  }
  
  function getMembers($startId, $number) {
	  $startId = $startId + 0;
	  $number = $number + 0;
	  
	  $query = "SELECT * FROM member LIMIT $startId, $number";
	  $result = mysql_query($query);
	
	  $index = 0;
	  while ($row = mysql_fetch_assoc($result)) {
	  	$members[$index] = $this->getUserFromRow($row);
		$index++;
	  }
	  return $members;
  }
  
  function getNumberOfMembers() {
		$query = "SELECT COUNT(*) FROM member";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
  }


  /**
   * Deletes user from the database.
   * Returns true if successful / false if nothing deleted
   */
  function delete(&$vo) {
    $id = $vo->getId() + 0;

    // Ensure object exists in database
    if ($this->get($id) == null) {
      return false;
    }
    $query = "DELETE FROM member WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    $vo->setId(0);

    return $result;
  }

  function update(&$vo) {
    $id = $vo->getId();

    if ($id <= 0) return false;

    $query = "UPDATE member SET first_name='".mysql_real_escape_string($vo->getFirstName())."', last_name='".mysql_real_escape_string($vo->getLastName())."', email='".mysql_real_escape_string($vo->getEmail())."', preferred_contact='".mysql_real_escape_string($vo->getPreferredContact())."', volunteer_contact='".mysql_real_escape_string($vo->getVolunteerContact())."', membership_type='".mysql_real_escape_string($vo->getMembershipType())."' WHERE id=$id LIMIT 1";
    return mysql_query($query);

  }

  /**
   * Insert the object into the database.
   * Return the id
   */
  function insert(&$vo) {
    $query = "INSERT INTO member (first_name, last_name, email, phone, preferred_contact, volunteer_contact, membership_type) VALUES ('".mysql_real_escape_string($vo->getFirstName())."', '".mysql_real_escape_string($vo->getLastName())."', '".mysql_real_escape_string($vo->getEmail())."', '".mysql_real_escape_string($vo->getPhone())."', '".mysql_real_escape_string($vo->getPreferredContact())."', '".mysql_real_escape_string($vo->getVolunteerContact())."', '".mysql_real_escape_string($vo->getMembershipType())."')";
    mysql_query($query);
    return mysql_insert_id();
  }
}
