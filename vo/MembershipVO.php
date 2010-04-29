<?php
class MembershipVO {

	var $id;
	var $description;
	var $cost;
	
	/** 
	 * Constructor
	 */
	function __construct ($idIn = 0, $descriptionIn = 0, $costIn = "") {
		$this->id = $idIn;
		$this->description = $descriptionIn;
		$this->cost = $costIn;
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
	
	  function getDescription() {
		  return $this->description;
	  }
	  function setDescription($descriptionIn) {
		  $this->member_id = $descriptionIn;
	  }
	
	  function getCost() {
		  return $this->cost;
	  }
	  function setCost($costIn) {
		  $this->cost = $costIn;
	  }
}