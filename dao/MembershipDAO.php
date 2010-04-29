<?php

class MembershipDAO {
  var $conn;

  function MembershipDAO(&$conn) {
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
 
//  ($idIn = 0, $descriptionIn = 0, $costIn = "")


  function getUserFromResult($result) {
    $row = mysql_fetch_assoc($result);
    return getUserFromRow($row);
  }
  
  function getUserFromRow($row) {
    return new MembershipVO($row["id"], $row["description"], $row["cost"]);
  }

  function get($id) {
    $id = $id + 0; // force into int
    $query = "SELECT * FROM membership WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    if (!$result) {
      return null;
    }
    return $this->getUserFromResult($result);
  }
  
  function getAll() {
 		$query = "SELECT * FROM membership";
		$result = mysql_query($query);
		$index = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$memberships[$index] = $this->getUserFromRow($row);
			$index++;
		}
		return $memberships;
  }

  function getByMember($memberId) {
		$memberId = $memberId + 0;
		$query = "SELECT membership_type FROM member WHERE id=$memberId";
		$result = mysql_query($query);
		if (!$result || mysql_num_rows($result) == 0) return null;
		$membershipId = mysql_fetch_array($result);
		$membershipId = $membershipId[0];
		
		$query = "SELECT * FROM membership WHERE id=$membershipId";
		$result = mysql_query($query);
		if (!$result) {
			return null;	
		}
		return $this->getUserFromResult($result);
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
    $query = "DELETE FROM membership WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    $vo->setId(0);

    return $result;
  }

  function update(&$vo) {
    $id = $vo->getId();

    if ($id <= 0) return false;

    $query = "UPDATE membership SET description='".mysql_real_escape_string($vo->getDescription())."', cost='".mysql_real_escape_string($vo->getCost())."' WHERE id=$id LIMIT 1";
    return mysql_query($query);

  }

  /**
   * Insert the object into the database.
   * Return the id
   */
  function insert(&$vo) {
    $query = "INSERT INTO membership (description, cost) VALUES ('".mysql_real_escape_string($vo->getDescription())."', '".mysql_real_escape_string($vo->getCost())."')";
    mysql_query($query);
    return mysql_insert_id();
  }
}
