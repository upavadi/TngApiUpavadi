<!-- Death Anniversaries Modified for BootStrap March 2016-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family Death Anniversaries</title>
</head>

<form action="#" style="display: inline-block;" method="get">
<label style="text-align: right; width: 108px;" for="monthselect3">Change Month:</label>
<select name="monthselect3" style="width: 100px; margin: 5px;" id="monthSelect3" onchange="runDeath()">
<option value="">--Select Month--</option>
<?php
$monthList = array(
	'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
	);
for ($i = 0; $i <= 11; $i++) {
$currentmonth = $i + 1;
if ($currentmonth < 10) {
$currentmonth = "0". $currentmonth;
$currentmonthyear = $currentmonth. $year;
}
if ($currentmonth == $month) {
?>
<option value="<?php echo $currentmonth;?>" selected="selected"><?php echo $monthList[$i] ?></option>
<?php
} else {
?>
<option value="<?php echo $currentmonth;?>"><?php echo $monthList[$i] ?></option>
<?php } }  ?>
</select>
<?php
$currentyear = $year;
?>
<label for="yearselect3" style="text-align: right; width: 108px;">Change Year:</label>
<select name="yearselect3" id="yearSelect3" style="width: 100px; margin: 5px;" onchange="runDeath()">
<option value="">--Select Year--</option>
<option value="<?php echo $currentyear-3;?>"><?php echo $currentyear-3;?></option>
<option value="<?php echo $currentyear-2;?>"><?php echo $currentyear-2;?></option>
<option value="<?php echo $currentyear-1;?>"><?php echo $currentyear-1;?></option>
<option value="<?php echo $currentyear;?>" selected="selected"><?php echo $currentyear;?></option>
<option value="<?php echo $currentyear+1;?>"><?php echo $currentyear+1;?></option>
<option value="<?php echo $currentyear+2;?>"><?php echo $currentyear+2;?></option>
<option value="<?php echo $currentyear+3;?>"><?php echo $currentyear+3;?></option>
</select>
<input type="hidden" id="deathMonthYear" name="monthyear">
 <input type="submit" value="Update" style="width:85px; margin: 10px;" />  
 <input type="submit"  value="Today" onclick="goToToday()"/> 
</form>
<script>
function runDeath() {
    document.getElementById("deathMonthYear").value = "01/" + document.getElementById("monthSelect3").value + "/" + document.getElementById("yearSelect3").value;
}
function goToToday() {
    document.getElementById("birthMonthYear").value = "01/" + document.getElementById("monthSelect").value + "/" + date("Y");
}
</script>
<!-- Get persons with death dates this month and with default photo ---->

<?php 
$tngcontent = Upavadi_tngcontent::instance()->init();
	foreach ($danniversaries as $danniversary): 
		$danniversarydate = strtotime($danniversary['deathdate']);
		$Years = $year - date('Y', $danniversarydate);
		$tree = $danniversary['gedcom'];
 
		//get age at death
		//if ($danniversary['birthdatetr'] !== "0000-00-00") {
		$d_birtharray = explode("-", ($danniversary['birthdatetr']));
		$d_birthyear = $d_birtharray[0];
		$d_birthmonth = $d_birtharray[1];
		$d_birthday = $d_birtharray[2];
		$deatharray = explode("-", ($danniversary['deathdatetr']));
		$deathyear = $deatharray[0];
		$deathmonth = $deatharray[1];
		$deathday = $deatharray[2];
		$setBirthdate = new DateTime();
		$setBirthdate->setDate($d_birthyear, $d_birthmonth, $d_birthday);
		$setDeathdate = new DateTime();
		$setDeathdate->setDate($deathyear, $deathmonth, $deathday);
		$setBirthdate->format('c') . "<br / >\n";
		$setDeathdate->format('c') . "<br / >\n";
		$i = $setBirthdate->diff($setDeathdate);
		$i->format("%Y");
	
		$personId = $danniversary['personid'];
		$photosPath = $url. $photos;
		$birthdate = $danniversary['birthdate'];
		$deathdate = $danniversary['deathdate'];
		$name = $danniversary['firstname']. " ". $danniversary['lastname'];

		$b_monthName = date("F", mktime(0, 0, 0, $d_birhtmonth, 10)); 
		$d_monthName = date("F", mktime(0, 0, 0, $deathmonth, 10));
		

		$birthdate = $d_birthday." ". $b_monthName. " ". $d_birthyear; 
		$deathdate = $deathday." ". $d_monthName. " ". $deathyear;
		$defaultmedia = $tngcontent->getDefaultMedia($personId, null);

		if ($danniversary['birthdatetr'] !== "0000-00-00") {
			$ageAtDeath = $i->format("%Y");
			}
			else 
			{ 	
				$ageAtDeath = "";
				$birthdate = "";
			}
		
		$photos = $tngcontent->getTngPhotoFolder();
		$url = $tngcontent->getTngUrl();
		$photosPath = $url. $photos;
		$mediaID = $photosPath."/". $defaultmedia['thumbpath'];
		
	?>
	<div style="margin: 35px"> 
	<div style="margin: 10px">
		<img src="<?php 
		echo "$mediaID";  ?>" border='1' height='50' border-color='#000000'/>
		<?php echo $defaultmedia['thumbpath']; ?>
	</div>
	<div> <?php echo "http://www.upavadi.net"; ?> </div>
	<div> <b><?php echo $name; ?></b> </div>
	<div> <?php echo $Years. " years ago, today,". " ( ". $birthdate. " - ". $deathdate. " ), aged ". $ageAtDeath. " years."; ?> </div>
	<div> Hari Aum.  🙏 🙏🙏🏼</div>
	<div> 
	http://www.upavadi.net/tng/getperson.php?personID=<?php echo $personId; ?> &tree=upavadi_1
	<?php //echo "http://www.upavadi.net/tng/getperson.php?personID=". $personId. " &tree=upavadi_1";
	?> 
	</div>
	</div>
	<?php 
	
	endforeach; 
	?>

