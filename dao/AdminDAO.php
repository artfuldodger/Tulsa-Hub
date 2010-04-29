<?php

class AdminDAO {
  var $conn;

  function AdminDAO(&$conn) {
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

  function getUserFromResult($result) {
    $row = mysql_fetch_assoc($result);
    $user = new AdminVO($row["id"], $row["username"], $row["email"], $row["display_name"]);
    return $user;
  }

  function authenticate($username, $password) {
    if ($username == null || $password == null || trim($username) == "" || trim($password) == "") {
      return null;
    }
    $query = "SELECT * FROM admin WHERE username='".mysql_real_escape_string($username)."' AND password='".md5($password)."'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) != 1) {
      return null;
    }
    return $this->getUserFromResult($result);
  }

  function get($id) {
    $id = $id + 0; // force into int
    $query = "SELECT * FROM admin WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    if (!$result) {
      return null;
    }
    return $this->getUserFromResult($result);
  }

  function getByUsername($username) {
    $query = "SELECT * FROM admin WHERE username='".mysql_real_escape_string($username)."'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) <= 0) {
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
    $query = "DELETE FROM admin WHERE id=$id LIMIT 1";
    $result = mysql_query($query);
    $vo->setId(0);

    return $result;
  }

  function update(&$vo) {
    $id = $vo->getId();

    if ($id <= 0) return false;

    $query = "UPDATE admin SET username='".mysql_real_escape_string($vo->getUsername())."', email='".mysql_real_escape_string($vo->getEmail())."', display_name='".mysql_real_escape_string($vo->getDisplayName())."' WHERE id=$id LIMIT 1";
    return mysql_query($query);

  }

  /**
   * Insert the object into the database.
   * Return the id
   */
  function insert(&$vo) {
    $query = "INSERT INTO admin (username, email, display_name, password) VALUES ('".mysql_real_escape_string($vo->getUsername())."', '".mysql_real_escape_string($vo->getEmail())."', '".mysql_real_escape_string($vo->getDisplayName())."', '".md5($vo->getPassword())."')";
    mysql_query($query);
    return mysql_insert_id();
  }
}
