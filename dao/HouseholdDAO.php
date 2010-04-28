<?php

class HouseholdDAO {
  var $conn;

  function UserDAO(&$conn) {
    $this->conn =& $conn;
  }

  function save(&$vo) {
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
    return getUserFromRow($row);
  }
  
  function getUserFromRow($row) {
    return new HouseholdVO($row["id"], $row["member_id"], $row["name"]);
  }

  function get($id) {
    $id = $id + 0; // force into int
    $query = "SELECT * FROM member_household WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    if (!$result) {
      return null;
    }
    return $this->getUserFromResult($result);
  }

  function getByMember($memberId) {
		$memberId = $memberId + 0;
		$query = "SELECT * FROM member_household WHERE member_id=$memberId";
		$result = mysql_query($query);
		if (!$result) {
			return null;	
		}
		$index = 0;
		while ($row = mysql_fetch_assoc($result)) {
				$householdMembers[$index] = getUserFromRow($row);
				$index++;
		}
		return $householdMembers;
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
    $query = "DELETE FROM member_household WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    $vo->setId(0);

    return $result;
  }

  function update(&$vo) {
    $id = $vo->getId();

    if ($id <= 0) return false;

    $query = "UPDATE member_household SET name='".mysql_real_escape_string($vo->getName())."' WHERE id=$id LIMIT 1";
    return mysql_query($query);

  }

  /**
   * Insert the object into the database.
   * Return the id
   */
  function insert(&$vo) {
    $query = "INSERT INTO member_household (member_id, name) VALUES ('".mysql_real_escape_string($vo->getMemberId())."', '".mysql_real_escape_string($vo->getName())."')";
    mysql_query($query);
    return mysql_insert_id();
  }
}
