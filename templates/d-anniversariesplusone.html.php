<h2>Death Anniversaries for <?php echo $date; ?></h2>
Clicking on a name takes you to the Individual's Family Page</br> Clicking on VIEW will show your relationship to the individual (Blood relationships only)
<table cellspacing="1" cellpadding="1" border="1">
	<tbody>
		
			<th class="theader" style="text-align: center">Name</th>
			<th class="theader" style="text-align: center">Date</th>
			<th class="theader" style="text-align: center">Death Place</th>
			<th class="theader" style="text-align: center">Years</th>
			<th class="theader" style="text-align: center">Age at Death</th>
			<th class="theader" style="text-align: center">Birth date</th>
			<th class="theader"style="text-align: center">Relationship</th>
		
		<?php 
		$tngcontent = Upavadi_TngContent::instance();
		foreach ($danniversariesplusone as $danniversary):
		$tree = $danniversary['gedcom'];
		$personId = $danniversary['personid'];
		$tngfolder = $tngFolder;
		$birthdate = $danniversary['birthdate'];
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
		http://localhost/tng1013/getperson.php?personID=I580
		?>
		<tr>
			<td style="text-align: center"><div>
			<?php if ($dmedia['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?><br /> 
			
			<a href="../<?php echo $tngfolder;?>/getperson.php?personID=<?php echo $danniversary['personid'];?>">
			<?php echo $name; ?></a></div></td>
			<td style="text-align: center"><?php echo $danniversary['deathdate']; ?></td>
			<td style="text-align: center"><?php echo $danniversary['deathplace']; ?></td>
			<td style="text-align: center"><?php echo $danniversary['Years']; ?></td>
			<td style="text-align: center"><?php echo $ageAtDeath; ?></td>
			<td style="text-align: center"><?php echo $birthdate; ?></td>
			<td style="text-align: center"><a href="../<?php echo $tngfolder;?>/relationship.php?altprimarypersonID=&savedpersonID=&secondpersonID=<?php echo $danniversary['personid'];?>&maxrels=2&disallowspouses=0&generations=15&tree=upavadi_1&primarypersonID=<?php echo $currentperson; ?>"><?php echo "View"?></td>
			
		</tr>
<?php endforeach; ?>
	</tbody>
</table>



