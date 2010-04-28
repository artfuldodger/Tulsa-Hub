<?php
class MemberVO {
  var $id;
  var $first_name;
  var $last_name;
  var $email;
  var $phone;
  var $preferred_contact;
  var $volunteer_contact;
  var $membership_type;
  var $sign_up;

  /** 
   * Constructor
   */
  function __construct ($idIn = 0, $firstNameIn = "", $lastNameIn = "", $emailIn = "", $phoneIn = "", $preferredContactIn = "", $volunteerContactIn = "", $membershipTypeIn = "", $signUpIn = "") {
      $this->id = $idIn;
      $this->first_name = $firstNameIn;
	  $this->last_name = $lastNameIn;
	  $this->email = $emailIn;
	  $this->phone = $phoneIn;
	  $this->preferred_contact = $preferredContactIn;
	  $this->volunteer_contact = $volunteerContactIn;
	  $this->membership_type = $membershipTypeIn;
	  $this->sign_up = $signUpIn;
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

  function getFirstName() {
      return $this->first_name;
  }
  function setFirstName($first_nameIn) {
      $this->first_name = $first_nameIn;
  }
  
  function getLastName() {
      return $this->last_name;
  }
  function setLastName($last_nameIn) {
      $this->last_name = $last_nameIn;
  }

  function getPhone() {
	return $this->phone;  
  }
  function setPhone($phoneIn) {
	  $this->phone = $phoneIn;
  }
  
  function getPreferredContact() {
	return $this->preferred_contact;  
  }
  function setPreferredContact($preferredContactIn) {
	$this->preferred_contact=$preferredContactIn;  
  }
  
  function getVolunteerContact() {
	return $this->volunteer_contact;  
  }
  function setVolunteerContact($volunteerContactIn) {
	  $this->volunteer_contact = $volunteerContactIn;
  }
  
  function getMembershipType() {
	return $this->membership_type;  
  }
  function setMembershipType($membershipTypeIn) {
	  $this->membership_type = $membershipTypeIn;
  }
  
  function getSignUp() {
	  return $this->sign_up;
  }
  function setSignUp($signUpIn) {
	$this->sign_up = $signUpIn;  
  }

  function toString() {
    return 'id='.$this->getId().', name='.$this->getFirstName().' '.$this->getLastName().', email='.$this->getEmail();
  }
}
