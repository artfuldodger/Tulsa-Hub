<?php
class AdminVO {
  var $id;
  var $username;
  var $email;
  var $display_name;
  var $password;

  /** 
   * Constructor
   */
  function __construct ($idIn = 0, $usernameIn = "", $emailIn = "", $displayNameIn = "") {
      $this->id = $idIn;
      $this->username = $usernameIn;
      $this->email = $emailIn;
      $this->display_name = $displayNameIn;
  }


  /** 
   * Get- and Set-methods for persistent variables. The default
   * behaviour does not make any checks against malformed data,
   * so these might require some manual additions.
   */

  function getId() {
      return $this->id;
  }
  function setId($idIn) {
      $this->id = $idIn;
  }

  function getUsername() {
      return $this->username;
  }
  function setUsername($usernameIn) {
      $this->username = $usernameIn;
  }

  function getEmail() {
      return $this->email;
  }
  function setEmail($emailIn) {
      $this->email = $emailIn;
  }

  function getDisplayName() {
      return $this->display_name;
  }
  function setDisplay_name($display_nameIn) {
      $this->display_name = $display_nameIn;
  }

  function getPassword() {
    return $this->password;
  }
  function setPassword($passwordIn) {
    $this->password = $passwordIn;
  }

  function toString() {
    return 'id='.$this->getId().', username='.$this->getUsername().', display_name='.$this->getDisplayName();
  }
}
