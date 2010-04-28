<?php
include "vo/MemberVO.php";
if (!logged_in()) {
	die("You must be logged in to see this page.");	
}

$NUM_MEMBERS_PER_PAGE = 50;

$dao = getDao("member");

if (!isset($_GET["page"]) || $_GET["page"] < 1) {
	$_GET["page"] = 1;	
}

$page = $_GET["page"] - 1;

$members = $dao->getMembers($page*$NUM_MEMBERS_PER_PAGE, $NUM_MEMBERS_PER_PAGE);
$numberOfMembers = $dao->getNumberOfMembers();

if ($numberOfMembers > $NUM_MEMBERS_PER_PAGE) {
	$numPages = ceil($numberOfMembers/$NUM_MEMBERS_PER_PAGE);
	echo '<p>Page: ';
	for ($i = 1; $i <= $numPages; $i++) {
		if ($_GET["page"] == $i) {
			echo '$i';	
		} else {
			echo '<a href="/index.php?page=',$i,'">',$i,'</a>';	
		}
		echo ' ';
	}
}

if (isset($_POST["add"])) {
	$member = new MemberVO(0, $_POST["first_name"], $_POST["last_name"], $_POST["email"], $_POST["phone"], $_POST["preferred_contact"], $_POST["volunteer_contact"], $_POST["membership_type"]);
	$dao->save($member);
}

?>

<form action="/index.php" method="post">

	<table>
    	<tr>
        	<td><label for="first_name">First Name:</label></td>
            <td><input type="text" name="first_name" id="first_name" /></td>
        </tr>
        <tr>
       		<td><label for="last_name">Last Name:</label></td>
            <td><input type="text" name="last_name" id="last_name" /></td>
        </tr>
        <tr>
        	<td><label for="email">E-mail Address:</label></td>
           	<td><input type="email" name="email" id="email" /></td>
        </tr>
        <tr>
        	<td><label for="phone">Phone/Cell:</label></td>
            <td><input type="text" name="phone" id="phone" /></td>
        </tr>
        <tr>
        	<td><label for="preferred_contact">Preferred Contact:</label></td>
            <td>
            	<input type="radio" name="preferred_contact" value="email" checked="checked" /> Email<br />
            	<input type="radio" name="preferred_contact" value="snail" /> Snail Mail<br />
                <input type="radio" name="preferred_contact" value="text" /> Text Message
            </td>
        </tr>
        <tr>
        	<td><label for="volunteer_contact">Volunteer Contact:</label></td>
            <td><input type="checkbox" name="volunteer_contact" id="volunteer_contact" /></td>
        </tr>
        <tr>
        	<td><label for="membership_type">Membership Type:</label></td>
            <td>
            	<input type="radio" name="membership_type" value="1" checked="checked" /> Individual $20<br />
            	<input type="radio" name="membership_type" value="2" /> Household (up to 3 people) $30<br />
                <input type="radio" name="membership_type" value="3" /> Student $15
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="household_members">If household, list other members:</label>
            </td>
            <td>
            	<input type="text" name="household_1" /><br />
                <input type="text" name="household_2" /><br />
                <input type="text" name="household_3" />
            </td>
        </tr>
        <tr>
        	<td colspan="2" style="text-align: right">
				<input type="submit" name="add" value="Add" />
            </td>
        </tr>
    </table>
</form>


<?php
if (count($members) <= 0) {
	echo '<p>There are no members!</p>';	
} else {
	foreach($members as $member) {
		echo '<p>',$member->toString(),'</p>';
	}

}