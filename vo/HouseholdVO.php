<?php
class HouseholdVO {

	var $id;
	var $member_id;
	var $name;
	
	/** 
	 * Constructor
	 */
	function __construct ($idIn = 0, $memberIdIn = 0, $nameIn = "") {
		$this->id = $idIn;
		$this->member_id = $memberIdIn;
		$this->name = $nameIn;
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
	
	  function getMemberId() {
		  return $this->member_id;
	  }
	  function setMemberId($memberIdIn) {
		  $this->member_id = $memberIdIn;
	  }
	
	  function getName() {
		  return $this->name;
	  }
	  function setName($nameIn) {
		  $this->name = $nameIn;
	  }
}