<?php
//$tngcustom = TngApiCustom_TngCustom()::instance()->init();
$tngcontent = Upavadi_TngContent::instance();
?>
<h2>Birthdays for <?php echo $date ?></h2>
Clicking on a name takes you to the Individual's Family Page
</br> Clicking on VIEW will show your relationship to the individual (Blood relationship only)								
<table border=1 cellSpacing=1 cellPadding=1>
	<tbody>
			<th style="background-color: #EDEDED; text-align: center;">Name</th>
			<th style="background-color: #EDEDED;">Date</th>
			<th style="background-color: #EDEDED;">Birth Place </th>
			<th style="background-color: #EDEDED; text-align: center;">Age </th>
			<th style="background-color: #EDEDED;">Relationship</th>
	
	<?php foreach ($birthdaysplusone as $birthday): 
	$tree = $birthday['gedcom'];
	$personId = $birthday['personid'];
	$dmedia = $tngcontent->getDefaultMedia($personId, $tree);
	$mediaPath = $photosPath."/". $dmedia['thumbpath'];
	?>
		<tr>
			<td style="text-align: center"><div>
			<?php if ($dmedia['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?><br /> 
			<a href="/family/?personId=<?php echo $birthday['personid'];?>&amp;tree=<?php echo $tree; ?>">
            <?php echo $birthday['firstname']. " "; ?><?php echo $birthday['lastname']; ?></a></div></td>
            <td style="text-align: center"><?php echo $birthday['birthdate']; ?></td>
			<td style="text-align: center"><?php echo $birthday['birthplace']; ?></td>
			<td style="text-align: center";><?php echo $birthday['Age']; ?></td>
			<td style="text-align: center";><a href="../genealogy/relationship.php?altprimarypersonID=&savedpersonID=&secondpersonID=<?php echo $birthday['personid'];?>&maxrels=2&disallowspouses=0&generations=15&tree=upavadi_1&primarypersonID=<?php echo $currentperson; ?>"><?php echo "View"?></td>
			
		</tr>
		
<?php endforeach; ?>
	</tbody>
</table>

