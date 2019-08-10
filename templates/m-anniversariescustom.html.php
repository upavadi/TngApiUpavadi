<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Customized Marriage Anniversaries</title>
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
</style>
<body>
<div class="row-fluid">
<form style="display: inline-block;" method="get">
    <label for="search-month">Select Month: <input type="text" value="<?php echo $monthyear; ?>" name="monthyear" id="search-monthyear" class="date-picker" /></label> 


<input type="submit" value="Update" style="width:50px; float:center" />
</form>
</div>
<?php
$tngcontent = Upavadi_TngContent::instance();

$date1 = date('F Y');
if ($branch != "" ) {
?>
<h2><span style="color:#D77600; font-size:25px">Wedding Anniversaries List for <?php echo $date->format('F Y'); ?></span></h2>
<h4>Customized Events for <?php echo $currentperson;?>. 
Clicking on a name takes you to the Individual's Family Page.</h4>								
<?php
} else {
?> 
<br /><b><span style="color:#D77600; font-size:16px">Customized Wedding Anniversaries List for <?php echo $currentperson ?> Not Prepared. Please contact Administrator to prepare one for you. 
<a href="../events">Go to Complete List</a></span></b>

<?php } ?>
<div class="container-fluid table-responsive">
<div class="col-md-12">
<table class="table table-bordered"> 
	<tr class="row">
			<td class="tdback col-md-3" style="text-align: center">Husband</td>
			<td class="tdback col-md-3" style="text-align: center">Wife</td>
			<td class="tdback col-md-2">Date</td>
			<td class="tdback col-md-2">Place</td>
			<td class="tdback col-md-2" style="text-align: center">Years</td>
			
	<?php 
	
	$tngcontent = Upavadi_tngcontent::instance()->init();
	
		foreach ($manniversariesBranch as $manniversary):
		$tree = $manniversary['gedcom'];
		$personId1 = $manniversary['personid1'];
		$personId2 = $manniversary['personid2'];
		$dmedia1 = $tngcontent->getDefaultMedia($personId1, $tree);
		$dmedia2 = $tngcontent->getDefaultMedia($personId2, $tree);
		$mediaPath1 = $photosPath."/". $dmedia1['thumbpath'];
		$mediaPath2 = $photosPath."/". $dmedia2['thumbpath'];
		$personId = $birthday['personID1'];
		$marrdate = strtotime($manniversary['marrdate']);
		$marr_month = date('m', $marrdate);
		$marr_day = date('d', $marrdate);
			if ($marr_day == $currentDay && $marr_month == $currentMonth) {
				$bornClass = 'born-highlight';
				} else {
				$bornClass = "";
			}
		
	?>
		<tr class="row">
			<td class="col-md-3" style="text-align: center">
			<div>
			<?php if ($dmedia1['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath1";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?>
			<br />
			<a href="/family/?personId=<?php echo $manniversary['personid1'];?>">
			<?php echo $manniversary['firstname1']; ?><?php echo $manniversary['lastname1']; ?></a></div></td>
			
			<td class="col-md-3" style="text-align: center">
			<?php if ($dmedia2['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath2";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?>
			<br />
			<a href="/family/?personId=<?php echo $manniversary['personid2'];?>">
			<?php echo $manniversary['firstname2']; ?><?php echo $manniversary['lastname2']; ?></a></div></td>
				
			<td class="col-md-2 <?php echo $bornClass; ?>"><style="text-align: center">
			<?php echo $manniversary['marrdate']; ?></a></td>
			
			
			
			<td class="col-md-2" style="text-align: center"><?php echo $manniversary['marrplace']; ?></td>
			<td class="col-md-2" style="text-align: center"><?php echo $manniversary['Years']; ?></td>
		</tr>
<?php endforeach; ?>
</table>
</div>
</div>
</body>
</html>
