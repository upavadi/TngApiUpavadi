<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Customized Birth dates</title>
</head>
<!---- Jquery date picker stat -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" type="text/css">
<script type="text/javascript">
		$(function() {
        $('.date-picker').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
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
</div>
<div class="row-fluid">	
<input type="submit" value="Update" style="width:50px; float:center" />
</form>
</div>

<?php
$tngcontent = Upavadi_TngContent::instance();
//$current_day = date("j"); 
$current_month = date("n");

if ($branch != "" ) {
?>
<h2><span style="color:#D77600; font-size:25px">Birthdays for <?php echo $date->format('F Y'); ?></span></h2>
<h4>Customized Events for <?php echo $currentperson;?>. 
Clicking on a name takes you to the Individual's Family Page.</h4>								
<?php
} else {
?> 
<br /><b><span style="color:#D77600; font-size:16px">Customized Birthdays List for <?php echo $currentperson ?> Not Prepared. Please contact Administrator to prepare one for you. 
<a href="../events">Go to Complete List</a></span></b>

<?php } ?>
<div class="container-fluid table-responsive">
<div class="col-md-12">
<table class="table table-bordered"> 

	<tr class="row">
		<td class="tdback col-md-6" style="text-align: center">Name</td>
		<td class="tdback col-md-2"> Date</td>
		<td class="tdback col-md-2" >Birth Place</td>
		<td class="tdback col-md-1" style="text-align: center">Age</td>
		<td class="tdback col-md-1" style="text-align: center">Relationship</td>
	</tr>	
	<?php foreach ($birthdaysBranch as $birthday): 
	
	$tree = $birthday['gedcom'];
	$personId = $birthday['personID1'];
	$birthdate = strtotime($birthday['birthdate']);
	
	$birth_month = date('m', $birthdate);
	$birth_day = date('d', $birthdate);
	
    if ($birthday['living'] == "1") {
	$age = $year - date('Y', $birthdate);
	} else {
	$age = $year - date('Y', $birthdate);
	$age = "HariOm";
	}
	
	
	if ($birth_day == $currentDay && $birth_month == $currentMonth) {
	$bornClass = 'born-highlight';
	} else {
	$bornClass = "";
	}
	$dmedia = $tngcontent->getDefaultMedia($personId, $tree);
	$mediaPath = $photosPath."/". $dmedia['thumbpath'];
	
	?>
	<tr class="row">
			<td class="col-md-6" style="text-align: center">
			<?php if ($dmedia['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?><br /> 
			<a href="/family/?personId=<?php echo $birthday['personID1'];?>&amp;tree=<?php echo $tree; ?>">
            <?php echo $birthday['firstname']. " "; ?><?php echo $birthday['lastname']; ?></a></div></td>
            <td class="col-md-2 <?php echo $bornClass; ?>"><?php echo $birthday['birthdate']; ?></td>
            <td class="col-md-2" style="text-align: center"><?php echo $birthday['birthplace']; ?></td>
            <td class="col-md-1" style="text-align: center"><?php echo $age, $highlight; ?></td>
			<td class="col-md-1" style="text-align: center"><a href="../genealogy/relationship.php?altprimarypersonID=&savedpersonID=&secondpersonID=<?php echo $birthday['personID1'];?>&maxrels=2&disallowspouses=0&generations=15&tree=upavadi_1&primarypersonID=<?php echo $currentPersonId; ?>"><?php echo "View"?></td>
			
		</tr>
		
<?php endforeach; ?>

</table>
</div>
</div>
</body>
</html>