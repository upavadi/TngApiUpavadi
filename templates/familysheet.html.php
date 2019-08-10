 <!-- FAMILY Sheet designed to send to users. The form list user, user parents, spouse(s) and children.
 
 <td class="tdfront"><span style="color:#777777">(This is always Father's Surname)<br/></span><?php if($lastname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $lastname; ?></b></span></td>
ISSUES: line 54: Can not get tng_users row
line 25: display selected
line 136: Eventdisplay function not working	
If OR statement

<a href="?personId=<?php echo $childPerson['personID']; ?>">
 -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    
	<form>
	<?php
	
	$args = array ('name' => 'userID', 'selected' => 'first_name',);
   wp_dropdown_users($args); 
    ?>
	
   <input type="submit" value="Select User" />
   </form>
	</head>
    <?php
	
    
    $tngcontent = Upavadi_TngContent::instance();
	
//Get Member details

	$memberId = $_GET["userID"];
	$tngId = get_user_meta($memberId, 'tng_user_id', true);
	$member_info = get_userdata($memberId);
	$UserName = $member_info->user_login;
	$FirstName = get_user_meta($memberId, 'first_name', true);

//connect to tng DB 
	global $wpdb;
		$dbHost = esc_attr(get_option('tng-api-db-host'));
        $dbUser = esc_attr(get_option('tng-api-db-user'));
        $dbPassword = esc_attr(get_option('tng-api-db-password', true));
        $dbName = esc_attr(get_option('tng-api-db-database'));

		$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
		if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
		}
		
//get user last login
		$tnglogin = $mysqli->query("SELECT lastlogin FROM tng_users WHERE userID = $tngId")->fetch_object()->lastlogin;
		$Member = $mysqli->query("SELECT personID FROM tng_users WHERE userID = $tngId")->fetch_object()->personID;

		if ($tnglogin == "") {
		$Memberlogin_date = "Not Yet";
		} elseif ($tnglogin == "0000-00-00 00:00:00") {
		$Memberlogin_date = "Not Yet";
		} else {
		$Memberlogin_date = date('d M Y', strtotime($tnglogin));
		}
		$mysqli->close();
		
		$currentperson = $Member;
		
		//get and hold current user
		//$currentperson = $tngcontent->getCurrentPersonId($person['personID']);
		$currentperson = $tngcontent->getPerson($currentperson);
		$currentuser = ($currentperson['firstname']);
		// user for upload photo
		//$current_user = wp_get_current_user();
    
	
    //get person details
	$personID = $Member; 
    $person = $tngcontent->getPerson($personID);
    $birthdate = $person['birthdate'];
    $birthdatetr = ($person['birthdatetr']);
    $birthplace = $person['birthplace'];
    $deathdate = $person['deathdate'];
    $deathdatetr = ($person['deathdatetr']);
    $deathplace = $person['deathplace'];
    $firstname = $person['firstname'];
	$lastname = $person['lastname'];
	if ($person['lastname'] == null) {
	$lastname = "Unknown";
	}
	
//get of the events
    $currentmonth = date("m");

    if ($birthdatetr == '0000-00-00') {
        $birthmonth = null;
        $birthdate = "Date unknown";
    } else {
        $birthmonth = substr($birthdatetr, -5, 2);
    }
    if ($person['birthplace'] == null) {
        $birthplace = "Unknown";
    } else {
        $birthplace = $person['birthplace'];
    }

    If ($currentmonth == $birthmonth) {
        $bornClass = 'born-highlight';
    } else {
        $bornClass = "";
    }

    if ($deathdatetr == "0000-00-00") {
        $deathmonth = null;
    } else {
        $deathmonth = substr($deathdatetr, -5, 2);
    }

//get gotra
	
    $personRow = $tngcontent->getGotra($person['personID']);
	$gotra = $personRow['info'];

	//get Description of Event type THIS IS NOT WORKING//
	
	//$EventRow = $tngcontent->getEventDisplay($event['display']);	
	$EventDisplay = $EventRow['display'];
	$EventDisplay = "Gotra";
//get familyuser
    if ($person['sex'] == 'M') {
        $sortBy = 'husborder';
    } else if ($person['sex'] == 'F') {
        $sortBy = 'wifeorder';
    } else {
        $sortBy = null;
    }
    if ($person['living'] == '0' AND $person['deathdatetr'] !== '0000-00-00') {
        $deathdate = " died: " . $person['deathdate'];
    } else {
        $deathdate = " died: Date unknown";
    }
    if ($person['living'] == '1') {
        $deathdate = "  (Living)";
    }
    if ($person['living'] == '0' AND $person['deathplace'] == "") {
        $deathplace = "Unknown";
    }
	
    $families = $tngcontent->getFamilyUser($person['personID'], $sortBy);
   
    ?>
	<!-- text for intro below -->
	<br/>
	Dear <?php echo $FirstName ?>,
	<br/><br/>
   <p>Just over 3 years ago, we moved to our new <a href="http://www.upavadi.net/">Family Genealogy site</a>. The responses, so far, have been very positive.
   </p>
   <P>I think time has come to carry out an audit of the data in the Family Tree. So I wonder if I may ask you, to spare a few moments and look at the data I hold about your immediate family.
   </p>
   <p>Please check the details below for accuracy. If there are any additions or corrections to be made, enter them in the column marked <b>Change / Update Details</b>. I have highlighted missing data in RED. I would really appreciate it if you could update the missing data. 
   </P>
   <p>I have not included any details about siblings or grand children (if any). To do so would have made this form very long and convoluted. 
    You may check these by visiting <a href="http://www.upavadi.net/family/">your family page</a> (Please remember that you would have to log-in to view these details.) If this is not possible, please let me know and I shall send you an appropriate form.
   </p>
   <p>Finally, if the details I have sent, do not display properly, let me know and I shall convert this in to a Word document and send it to you.
   </p>
   <p> I am really looking forward to your feedback. Please do hit the reply button - even if it is just to let me know that all details are correct.
   </p>
   <p>
   Fondest regards
<br/><br/>
Mahesh Upadhyaya
<br/>
Administrator of the Website of
<br/>
<a href="http://www.upavadi.net/">Upadhyaya Family & Relatives.</a></p>
   
   
   <!-- text for intro above -->
    
	<B>Your Membership Details</B>
	 <table width="100%" border="1">
       <tbody>
		<th style="background-color: #EDEDED; width: 60px;">Log-In  </th>
		<th style="background-color: #EDEDED;">  Data in database</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
		<Tr>
			<td class="tdback"><?php echo "Your User Name"; ?></td>
			<td class="tdfront"><?php echo $UserName;?></td>
			<td class="tdfront"><?php echo "  If you would like to change your user name to something you can remember, enter it here."; ?></td>
			
		</tr>
		<tr>
			<td class="tdback"><?php echo "Your Password"; ?></td>
			<td class="tdfront"><?php echo "Not known to me";?></td>
			<td class="tdfront"><?php echo "If you have lost your password,";?> <a href="http://www.upavadi.net/">visit our website</a>.<?php echo " Click on Lost Password, on top right side, to get new password OR contact me. "; ?></td>
			
			
		</tr>
		<tr>
			<td class="tdback"><?php echo "Your Last Visit"; ?></td>
			<td class="tdfront"><?php echo $Memberlogin_date;?></td>
			<td class="tdfront"><?php echo " "; ?></td>
			
			
	</table>
	<br>	
	
        <?php
        $parents = '';
        $parents = $tngcontent->getFamilyById($person['famc']);

        if ($person['famc'] !== '' and $parents['wife'] !== '') {
            $mother = $tngcontent->getPerson($parents['wife']);
        }
        if ($person['famc'] !== ''and $parents['husband'] !== '') {
            $father = $tngcontent->getPerson($parents['husband']);
        }
        ?>
        <tbody>
            <tr>
                <?php
                if ($father['living'] == '0' AND $father['deathdatetr'] !== '0000-00-00') {
                    $fatherdeathdate = $father['deathdate'];
                } else { if ($father['famc'] == null) { 
					$fatherdeathdate = "Unknown";
					}
					else {
                    $fatherdeathdate = " died: Date unknown";
                }
				}
                if ($father['living'] == '1') {
                    $fatherdeathdate = "  (Living)";
                }

                if ($father['firstname'] == null) {
                    $fatherfirstname = "Unknown";
					} else {
                    $fatherfirstname = $father['firstname'];
				}
				if ($father['lastname'] == '') {
                    $fathersurname = "Unknown";
					} else {				
					$fathersurname = $father['lastname'];
					
                }
				
				
                if ($father['birthdatetr'] == "0000-00-00" OR $person['famc'] == null) {
                    $fatherbirthmonth = null;
                    $fatherbirthdate = "Date unknown";
                } else {
                    $fatherbirthmonth = substr($father['birthdatetr'], -5, 2);
                    $fatherbirthdate = $father['birthdate'];
                }

                if ($father['birthplace'] == "" OR $person['famc'] == null) {
                    $fatherbirthplace = "Unknown";
                } else {
                    $fatherbirthplace = $father['birthplace'];
                }
		
                If ($currentmonth == $fatherbirthmonth) {
                    $bornClass = 'born-highlight';
                } else {
                    $bornClass = "";
                }

                if ($father['deathdatetr'] == "0000-00-00") {
                    $fatherdeathmonth = null;
                } else {
                    $fatherdeathmonth = substr($father['deathdatetr'], -5, 2);
                }

                if ($father['living'] == '0' AND $father['deathplace'] == '') {
                    $fatherdeathplace = "Unknown";
                } else {
				$fatherdeathplace = $father['deathplace'];
				}
				if ($father['living'] == '1') {
                                $fatherdeathplace = "  (not applicable)";
                            }
				/*
				if ($father['famc'] == null) {
				$fatherdeathplace = "Unknown";
				}
				*/
				// Father - Gotra
				if ($father['personID'] !== null)
				{
				$fatherRow = $tngcontent->getgotra($father['personID']);
				$father_gotra = $fatherRow['info'];
				} else {
				$father_gotra = "Unknown";
				}
				if ($father['living'] == '1') {
                    $fatherdeathdate = "  (Living)";
					
                }
				
                ?>
	

				<?php
                if ($mother['living'] == '0' AND $mother['deathdatetr'] !== '0000-00-00') {
                    $motherdeathdate = $mother['deathdate'];
                } else { if ($person['famc'] == null) { 
					$motherdeathdate = "Unknown";
					}
					else {
                    $motherdeathdate = " died: Date unknown";
                }
				}
                

                if ($mother['firstname'] == null) {
                    $motherfirstname = "Unknown";
					} else {
                    $motherfirstname = $mother['firstname'];
				}
				if ($mother['lastname'] == '') {
                    $mothersurname = "Unknown";
					} else {				
					$mothersurname = $mother['lastname'];
					
                }
				
				
                if ($mother['birthdatetr'] == "0000-00-00" OR $person['famc'] == null) {
                    $motherbirthmonth = null;
                    $motherbirthdate = "Date unknown";
                } else {
                    $motherbirthmonth = substr($mother['birthdatetr'], -5, 2);
                    $motherbirthdate = $mother['birthdate'];
                }

                if ($mother['birthplace'] == "" OR $person['famc'] == null) {
                    $motherbirthplace = "Unknown";
                } else {
                    $motherbirthplace = $mother['birthplace'];
                }
	
                If ($currentmonth == $motherbirthmonth) {
                    $bornClass = 'born-highlight';
                } else {
                    $bornClass = "";
                }

                if ($mother['deathdatetr'] == "0000-00-00") {
                    $motherdeathmonth = null;
                } else {
                    $motherdeathmonth = substr($mother['deathdatetr'], -5, 2);
                }

                if ($mother['living'] == '0' AND $mother['deathplace'] == '') {
                    $motherdeathplace = "Unknown";
                } else {
				$motherdeathplace = $mother['deathplace'];
				}
				
				if ($mother['living'] == '1') {
                    $motherdeathdate = "  (Living)";
					$motherdeathplace = " not applicable";
                }
				
// Mother - Gotra
				if ($mother['personID'] !== null)
				{
				$motherRow = $tngcontent->getgotra($mother['personID']);
				$mother_gotra = $motherRow['info'];
				} else {
				$mother_gotra = "Unknown";
				}
				
		   
			 
		 
// Parents Marriage
		         if ($parents['marrdatetr'] == "0000-00-00" OR $person['famc'] == null) {
                    $parentsbirthmonth = null;
                    $parentsmarrdate = "Date unknown";
                } else {
                    $parentsmarrmonth = substr($parents['marrdatetr'], -5, 2);
                    $parentsmarrdate = $parents['marrdate'];
                }

                if ($parents['marrplace'] == "" OR $person['famc'] == null) {
                    $parentsmarrplace = "Unknown";
                } else {
                    $parentsmarrplace = $parents['marrplace'];
                }
		
		
		 ?> 

		<br>
	<b>Your Details</b>
    <table width="100%" border="1">
       <tbody>
		<th style="background-color: #EDEDED; width: 60px;">You</th>
		<th style="background-color: #EDEDED;">Data in database</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
        <tr>
			<td class="tdback"><?php echo "First Name"; ?></td>
			<td class="tdfront"><span style="color:#777777">(Name - 2nd name or Father's Name)<br/></span><?php echo $firstname; ?></td>
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>	
			<td class="tdback"><?php echo "Surname"; ?></td>
			<td class="tdfront"><span style="color:#777777">(This is always Father's Surname)<br/></span><?php if($lastname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $lastname; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>		
			<td class="tdback"><?php echo $EventDisplay; ?></td>
			<td class="tdfront"><?php if($gotra == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $gotra; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
        </tr><tr>	
			<td class="tdback"><?php echo "Born"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($birthdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $birthdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Place of Birth"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($birthplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $birthplace; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr>
        </table>		
	<b>Your Parents:</b>
    <table width="100%" border="1">
       <tbody>
		<th style="background-color: #EDEDED; width: 60px;">Father</th>
		<th style="background-color: #EDEDED;">Data in database</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
			<tr>
			<td class="tdback"><?php echo "Father Name"; ?></td>
			<td class="tdfront"><span style="color:#777777">(Name - 2nd name or Father's Name)<br/></span><?php if($fatherfirstname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $fatherfirstname; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			</tr><tr>	
			<td class="tdback"><?php echo "Surname"; ?></td>
			<td class="tdfront"><span style="color:#777777">(This is always Father's Surname)<br/></span><?php if($fathersurname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $fathersurname; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>		
			<td class="tdback"><?php echo $EventDisplay; ?></td>
			<td class="tdfront"><?php if($father_gotra == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $father_gotra; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
        </tr><tr>	
			<td class="tdback"><?php echo "Birth date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($fatherbirthdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $fatherbirthdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Birth Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($fatherbirthplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $fatherbirthplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr><tr>	
			<td class="tdback"><?php echo "Death date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($fatherdeathdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $fatherdeathdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Death Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($fatherdeathplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $fatherdeathplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr>
        </table>		
    <table width="100%" border="1">
       <tbody>
		<th style="background-color: #EDEDED; width: 60px;">Mother</th>
		<th style="background-color: #EDEDED;">Data in database</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
			<tr>
			<td class="tdback"><?php echo "Mother Maiden Name"; ?></td>
			<td class="tdfront"><span style="color:#777777">(Name - 2nd name or Father's Name)<br/></span><?php if($motherfirstname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $motherfirstname; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			</tr><tr>	
			<td class="tdback"><?php echo "Surname"; ?></td>
			<td class="tdfront"><span style="color:#777777">(This is always Father's Surname)<br/></span><?php if($mothersurname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $mothersurname; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			<tr>
			<td class="tdback"><?php echo $EventDisplay; ?></td>
			<td class="tdfront"><?php if($mother_gotra == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $mother_gotra; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
        </tr><tr>	
			<td class="tdback"><?php echo "Birth date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($motherbirthdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $motherbirthdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Birth Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($motherbirthplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $motherbirthplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr><tr>	
			<td class="tdback"><?php echo "Death date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($motherdeathdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $motherdeathdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Death Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($motherdeathplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $motherdeathplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr>
		 </table>
		
		 
		 <table width="100%" border="1">
		<tbody>
		<th style="background-color: #EDEDED; width: 60px;">Your Parents</th>
		<th style="background-color: #EDEDED;">Data in database</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
        
		<tr>	
			<td class="tdback"><?php echo "Marriage date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($parentsmarrdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $parentsmarrdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr>
		 <tr>
		 <td class="tdback"><?php echo "Marriage Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($parentsmarrplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $parentsmarrplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			</tr>
        </table>
<!-- Spouse(s) -->
		<b>Your Spouse(s):</b>	
		<?php
        foreach ($families as $family):
            $marrdatetr = $family['marrdatetr'];
            $marrdate = $family['marrdate'];
            $marrplace = $family['marrplace'];
            $order = null;
            if ($sortBy && count($families) > 1) {
                $order = $family[$sortBy];
            }

            $spouse['personID'] == '';

            if ($person['personID'] == $family['wife']) {
                if ($family['husband'] !== '') {
                    $spouse = $tngcontent->getPerson($family['husband']);
                }
            }
            if ($person['personID'] == $family['husband']) {
                if ($family['wife'] !== '') {
                    $spouse = $tngcontent->getPerson($family['wife']);
                }
            }
			 if ($family['marrdate'] == '') {
                $spousemarrdate = "Date unknown";
            } else {
                $spousemarrdate = $family['marrdate'];
            }
            if ($family['marrplace'] == '') {
                $spousemarrplace = "Unknown";
            } else {
                $spousemarrplace = $family['marrplace'];
            }

            if ($spouse['birthdatetr'] == '0000-00-00') {
                $spousebirthdate = "Date unknown";
            } else {
                $spousebirthdate = $spouse['birthdate'];
            }
			if ($spouse['birthplace'] == "" OR $spouse['famc'] == null) {
                    $spousebirthplace = "Unknown";
                } else {
                    $spousebirthplace = $spouse['birthplace'];
                }

            if ($spouse['living'] == '0' AND $spouse['deathdatetr'] !== '0000-00-00') {
                $spousedeathdate = $spouse['deathdate'];
            } else {
                $spousedeathdate = " died: date unknown";
            }
            
			 if ($spouse['living'] == '0' AND $spouse['deathplace'] == '') {
                    $spousedeathplace = "Unknown";
                } else {
				$spousedeathplace = $spouse['deathplace'];
				}
				if ($spouse['famc'] == null) {
				$spousedeathplace = "Unknown";
				}
			if ($spouse['living'] == '1') {
                $spousedeathdate = "  (Living)";
				$spousedeathplace = " not applicable";
            }
             if ($spouse['firstname'] == null) {
                    $spousefirstname = "Unknown";
					} else {
                    $spousefirstname = $spouse['firstname'];
				}
				if ($spouse['lastname'] == '') {
                    $spousesurname = "Unknown";
					} else {				
					$spousesurname = $spouse['lastname'];
					
            if ($spouse['personID'] !== null)
				{
				$spouseRow = $tngcontent->getgotra($spouse['personID']);
				$spouse_gotra = $spouseRow['info'];
				} else {
				$spouse_gotra = "Unknown";
				}    }
            
			?>
			
		<table width="100%" border="1">
		<tbody>
		<th style="background-color: #EDEDED; width: 60px;">Your Spouse<?php echo " ". $order; ?></th>
		<th style="background-color: #EDEDED;">Data in database</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
        <tr>
			<td class="tdback"><?php echo "First Name"; ?></td>
			<td class="tdfront"><span style="color:#777777">(Name - 2nd name or Father's Name)<br/></span><?php if($spousesurname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousefirstname; ?></td>
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>	
			<td class="tdback"><?php echo "Surname"; ?></td>
			<td class="tdfront"><span style="color:#777777">(This is always Father's Surname)<br/></span><?php if($spousesurname == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousesurname; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>		
			<td class="tdback"><?php echo $EventDisplay; ?></td>
			<td class="tdfront"><?php if($spouse_gotra == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spouse_gotra; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
        </tr><tr>	
			<td class="tdback"><?php echo "Born"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($spousebirthdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousebirthdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Place of Birth"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($spousebirthplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousebirthplace; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr><tr>	
			<td class="tdback"><?php echo "Death date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($spousedeathdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousedeathdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Death Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($spousedeathplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousedeathplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr><tr>	
			<td class="tdback"><?php echo "Marriage date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($spousemarrdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousemarrdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr>
		 <tr>
		 <td class="tdback"><?php echo "Marriage Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($spousemarrplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $spousemarrplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			</tr>
		 </table>
		
<!-- Children -->	
	<?php
		$children = $tngcontent->getChildren($family['familyID']);
                        foreach ($children as $child):
                            $classes = array('child');
                            $childPerson = $tngcontent->getPerson($child['personID']);
                            $childFirstName = $childPerson['firstname'];
                            $childSurName = $childPerson['lastname'];
                            $childdeathdate = $childPerson['deathdate'];
							// Father - Gotra
							if ($childPerson['personID'] !== null)
							{
							$childPersonRow = $tngcontent->getgotra($childPerson['personID']);
							$childPerson_gotra = $childPersonRow['info'];
							} else {
							$childPerson_gotra = "Unknown";
							}
                            if ($child['haskids']) {
                                $haskids = 'Yes';
                            } else {
								 $haskids = 'No';
							}	 
							if ($childPerson['birthdatetr'] !== "0000-00-00") {
								$childbirthdate = $childPerson['birthdate'];
							}
							if ($childPerson['birthdatetr'] == "0000-00-00") {
								$childbirthdate = ("Date unknown");
							}
							
							if ($childPerson['birthplace'] !== "") {
								$childbirthplace = $childPerson['birthplace'];
							} else {
								$childbirthplace = ("Unknown");
							}
							if ($childPerson['living'] == '0' AND $childPerson['deathdatetr'] !== '0000-00-00') {
                                $childdeathdate = (" died: " . $childPerson['deathdate']);
                            } else {
                                $childdeathdate = " Date unknown";
                            }
                            if ($childPerson['living'] == '1') {
                                $childdeathplace = "  (not applicable)";
                            }
							if ($childPerson['living'] == '0' AND $childPerson['deathplace'] !== '') {
                                $childdeathplace = $childPerson['deathplace'];
                            } 
							if ($childPerson['living'] == '0' AND $childPerson['deathplace'] == '') {
                              $childdeathplace = "Unknown";
                            }
                            if ($childPerson['living'] == '1') {
                                $childdeathdate = "  (Living)";
                            }
							$childorder = $child['ordernum'];
	
			$childfamily = $tngcontent->getFamily($childPerson['personID']);
			$childmarrdatetr = $childfamily['marrdatetr'];
			$childmarrdatetr = $childfamily['marrdatetr'];
			$childfamilyid = $childfamily['familyID'];
				if ($childfamily['marrdatetr'] == "0000-00-00" AND $childfamilyid !=="") {
                    $childmarrdate = "Date unknown";
                } else {
                    $childmarrdate = $childfamily['marrdate'];
                }
				
                if ($childfamily['marrplace'] == "" OR $person['famc'] == null) {
                    $childmarrplace = "Unknown";
                } else {
                    $childmarrplace = $childfamily['marrplace'];
                }
				if ($childfamilyid =="") {
                    $childmarrdate = "Not Married";
					$childmarrplace = "N/A";
                } 
		
		//print_r($childfamily);
		?>					

		
		<table width="100%" border="1">
		<tbody>
		<th style="background-color: #EDEDED; width: 60px;">Child - <?php echo $childorder; ?></th>
		<th style="background-color: #EDEDED;">Data in database   (<?php echo "Spouse is ". $spousefirstname. $spousesurname; ?>)</th>
		<th style="background-color: #EDEDED; width: 60%;">Change / Update Details</th>
        <tr>
			<td class="tdback"><?php echo "First Name"; ?></td>
			<td class="tdfront"><span style="color:#777777">(Name - 2nd name or Father's Name)<br/></span><?php if($childFirstName == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childFirstName; ?></td>
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>	
			<td class="tdback"><?php echo "Surname"; ?></td>
			<td class="tdfront"><span style="color:#777777">(This is always Father's Surname)<br/></span><?php if($childSurName == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childSurName; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>		
			<td class="tdback"><?php echo $EventDisplay; ?></td>
			<td class="tdfront"><?php if($childPerson_gotra  == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childPerson_gotra ; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
        </tr><tr>	
			<td class="tdback"><?php echo "Born"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($childbirthdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childbirthdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Place of Birth"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($childbirthplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childbirthplace; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr><tr>	
			<td class="tdback"><?php echo "Death date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($childdeathdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childdeathdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr><tr>
			<td class="tdback"><?php echo "Death Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($childdeathplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childdeathplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
		 </tr><tr>	
			<td class="tdback"><?php echo "Marriage date"; ?></td>
			<td class="tdfront"><span style="color:#777777">(dd mmm yyyy)<br/></span><?php if($childmarrdate == "Date unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childmarrdate; ?></b></span></td>
			
			<td class="tdfront"><?php echo ""; ?></td>
		</tr>
		 <tr>
		 <td class="tdback"><?php echo "Marriage Place"; ?></td>
			<td class="tdfront"><span style="color:#777777">(as much detail as you can)<br/></span><?php if($childmarrplace == "Unknown"): ?><b><span style="color:red"><?php endif; ?><?php echo $childmarrplace; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			</tr><tr>
		 <td class="tdback"><?php echo "Has Children"; ?></td>
			<td class="tdfront"><?php echo $haskids; ?></b></span></td>
			<td class="tdfront"><?php echo ""; ?></td>
			</tr>
	 
		
		<?php
			
		endforeach;
			
        endforeach;
        ?>				

	</table>				
<!--get All notes -->
	<p><span style="font-size:14pt">
			
	Please enter any additional information below 
	</p>
	
	<?php
	

	$personID = $Member;
	$allnotes = $tngcontent->getNotes($personID);
$allnotes = $tngcontent->getnotes($personID);
		
		$note_generalID = "Additional Information ";
								
	?>	
		<p>
			<span style="font-size:14pt"><b>
			<?php echo $note_generalID;?></b></span></a></br>
			<textarea style="width:100%" name="note_general" rows="6" cols="100">
			<?php echo $note_general; ?>
			</textarea>
		</p>
		<p>
		
		Thank you for reading so far. I look forward to your feedback.
		<br/>
		Mahesh
		</p>
		
		
		
