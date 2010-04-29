<?php
include "vo/MemberVO.php";
include "vo/MembershipVO.php";
include "vo/HouseholdVO.php";
if (!logged_in()) {
	die("You must be logged in to see this page.");	
}

$NUM_MEMBERS_PER_PAGE = 50;

$dao = getDao("member");
$householdDao = getDao("household");

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
	if (isset($_POST["household_1"]) || isset($_POST["household_2"]) || isset($_POST["household_3"])) {
		if (trim($_POST["household_1"]) != "") {
			$household = new HouseholdVO(0, $member->getId(), $_POST["household_1"]);
			$householdDao->save($household);
		}
		if (trim($_POST["household_2"]) != "") {
			$household = new HouseholdVO(0, $member->getId(), $_POST["household_2"]);
			$householdDao->save($household);
		}
		if (trim($_POST["household_3"]) != "") {
			$household = new HouseholdVO(0, $member->getId(), $_POST["household_3"]);
			$householdDao->save($household);
		}
	}
}

?>
<h3>Add a new member</h3>
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
        	<td>Preferred Contact:</td>
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
        	<td>Membership Type:</td>
            <td>
            <?php
				$membershipDao = getDao("membership");
				$memberships = $membershipDao->getAll();
				foreach ($memberships as $membership) {
					echo '<input type="radio" name="membership_type" value="',$membership->getId(),'"';
					if ($membership->getId() == 1) {
						echo ' checked="checked"';	
					}
					echo ' /> ',$membership->getDescription(),' $',$membership->getCost(),'<br />';	
				}
				?>
            </td>
        </tr>
        <tr>
        	<td>
            	If household, list other members:
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
	echo '<h3>Member List</h3>';
	foreach($members as $member) {
		$preferredContact = $member->getPreferredContact();
		$membershipType = $member->getMembershipType();
		echo '
			<table>
				<tr>
					<td>Name:</td>
					<td>',$member->getFirstName(),' ',$member->getLastName(),'</td>
				</tr>
				<tr>
					<td>E-mail Address:</td>
					<td>',$member->getEmail(),'</td>
				</tr>
				<tr>
					<td>Phone/Cell:</td>
					<td>',$member->getPhone(),'</td>
				</tr>
				<tr>
					<td>Preferred Contact:</td>
					<td>',
						$preferredContact,
					'</td>
				</tr>
				<tr>
					<td><label for="volunteer_contact">Volunteer Contact:</label></td>
					<td>';
					if ($member->getVolunteerContact() == "1") {
						echo 'YES :)';	
					} else {
						echo 'no :(';	
					}
					echo '</td>
				</tr>
				<tr>
					<td>Membership Type:</td>
					<td>';
					
						$membershipDao = getDao("membership");
						$membership = $membershipDao->getByMember($member->getId());
						echo $membership->getDescription(), ' $', $membership->getCost();
echo '				</td>
				</tr>';
if ($membershipType == 2) {
	echo '
				<tr>
					<td>
						If household, list other members:
					</td>
					<td>';
	
						$households = $householdDao->getByMember($member->getId());
						if (count($households) <= 0) {
							echo 'No household members';
						} else {
							foreach ($households as $household) {
								echo $household->getName(),'<br />';	
							}
						}

echo '				</td>
				</tr>
	';
} // end if ($membershipType == 2)
		echo '
			</table>';
		echo '<hr />';
	} // end foreach

} // end else