<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Customized Birth dates</title>
</head>
<!---- Jquery date picker strat -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" type="text/css">

<script type="text/javascript">
    $(function() {
        $('.date-picker').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: false,
            dateFormat: '01/mm/yy',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));

            }
        });
    });
</script>
<style>
.ui-datepicker-calendar {
    display: none;
 }
  .born-highlight {
    background-color: #E0E0F7;
}
</style>
<body>
<div class="row-fluid">
<form style="display: inline-block;" method="get">
    <label for="search-month">Select Month: <input type="text" value="<?php echo $monthyear; ?>" name="monthyear" id="search-monthyear" class="date-picker" /></label> 


<input type="submit" value="Update" style="width:50px; float:center" />
</form>
</div>
<?php
//$tngcustom = TngApiCustom_TngCustom()::instance()->init();
$tngcontent = Upavadi_TngContent::instance();

$date1 = date('F Y');
if ($branch != "" ) {
?>
<h2><span style="color:#D77600; font-size:25px">Death Anniversaries List for <?php echo $date->format('F Y'); ?></span></h2>
<h4>Customized Events for <?php echo $currentperson;?>. 
Clicking on a name takes you to the Individual's Family Page.</h4>								
<?php
} else {
?> 
<br /><b><span style="color:#D77600; font-size:16px">Customized Death Anniversaries List for <?php echo $currentperson ?> Not Prepared. Please contact Administrator to prepare one for you. 
<a href="../events">Go to Complete List</a></span></b>

<?php } ?>
<div class="container-fluid table-responsive">
<div class="col-md-12">
<table class="table table-bordered"> 
	<tbody>
		
	<tr class="row">
		<td class="tdback col-md-3" style="text-align: center">Name</td>
		<td class="tdback col-md-3">Date</td>
		<td class="tdback col-md-2">Death Place</td>
		<td class="tdback col-md-2" style="text-align: center">Years</td>
		<td class="tdback col-md-1" style="text-align: center">Age at Death</td>
		<td class="tdback col-md-1" style="text-align: center">Relationship</td>
	</tr>		
<?php 
	$tngcontent = Upavadi_TngContent::instance();
		foreach ($danniversariescustom as $danniversary):
		$tree = $danniversary['gedcom'];
		$personId = $danniversary['personID1'];
		$name = $danniversary['firstname']. " ". $danniversary['lastname'];
		$dmedia = $tngcontent->getDefaultMedia($personId, $tree);
		$mediaPath = $photosPath."/". $dmedia['thumbpath'];
		//get age at death
		if ($danniversary['birthdatetr'] !== "0000-00-00") {
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
			$ageAtDeath = $i->format("%Y");
			}	else { 	$ageAtDeath = "";
		}
/** find current day and month to hif=ghlight **/
	$deathdate = strtotime($danniversary['deathdate']);
	$death_month = date('m', $deathdate);
	$death_day = date('d', $deathdate);
		if ($death_day == $currentDay && $death_month == $currentMonth) {
			$bornClass = 'born-highlight';
			} else {
			$bornClass = "";
		}		
		
		
		?>
	<tr class="row">
		<td class="col-md-3" style="text-align: center">
		<div>
		<?php if ($dmedia['thumbpath']) { ?>
		<img src="<?php 
		echo "$mediaPath";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?><br /> 
		<a href="/family/?personId=<?php echo $danniversary['personID1'];?>">
			<?php echo $name; ?></a></div></td>
		<td class="col-md-3 <?php echo $bornClass; ?>"><style="text-align: center"><?php echo $danniversary['deathdate']; ?></td>
		<td class="col-md-2" style="text-align: center"><?php echo $danniversary['deathplace']; ?></td>
		<td class="col-md-2" style="text-align: center"><?php echo $danniversary['Years']; ?></td>
		<td class="col-md-1" style="text-align: center"><?php echo $ageAtDeath; ?></td>
		<td class="col-md-1" style="text-align: center"><a href="../genealogy/relationship.php?altprimarypersonID=&savedpersonID=&secondpersonID=<?php echo $danniversary['personID1'];?>&maxrels=2&disallowspouses=0&generations=15&tree=upavadi_1&primarypersonID=<?php echo $currentPersonId; ?>"><?php echo "View"?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>
</div>
</body>



