<h2>Marriage Anniversaries for <?php echo date('F Y', strtotime('+1 month')); ?></h2>
Clicking on a name takes you to the Individual's Family Page.</br>
<table cellspacing="1" cellpadding="1" border="1">
	<tbody>
			<th style="background-color: #EDEDED; text-align: center;">Husband</th>
			<th style="background-color: #EDEDED; text-align: center;">Wife</th>
			<th style="background-color: #EDEDED; text-align: center;">Date</th>
			<th style="background-color: #EDEDED; text-align: center;">Place</th>
			<th style="background-color: #EDEDED; text-align: center;">Years</th>
	
	<?php 
	
	$tngcontent = Upavadi_tngcontent::instance()->init();
	$person = $tngcontent->getPerson($currentperson);
		foreach ($manniversariesplusone as $manniversary):
		$tree = $manniversary['gedcom'];
		$personId1 = $manniversary['personid1'];
		$personId2 = $manniversary['personid2'];
		$divorceDate = $manniversary['divdate'];
		$familyPrivacy = $manniversary['private'];
		$personPrivacy1 = $tngcontent->getPerson($personId1)['private'];
		$personPrivacy2 = $tngcontent->getPerson($personId2)['private'];
		$dmedia1 = $tngcontent->getDefaultMedia($personId1, $tree);
		$dmedia2 = $tngcontent->getDefaultMedia($personId2, $tree);
		$mediaPath1 = $photosPath."/". $dmedia1['thumbpath'];
		$mediaPath2 = $photosPath."/". $dmedia2['thumbpath'];

		if ($familyPrivacy) {
			$manniversary['firstname1'] = 'Private:';
			$manniversary['firstname2'] = 'Private:';
			$manniversary['lastname1'] = ' Details withheld';
			$manniversary['lastname2'] = ' Details withheld';
			$manniversary['marrdate'] = "?";
			$manniversary['Years'] = "";
			$mediaPath1 = $mediaPath2  = "";
			
		}

		if (!$familyPrivacy && $personPrivacy1) {
			$manniversary['firstname1'] = 'Private:';
			$manniversary['lastname1'] = ' Details withheld';
			$manniversary['marrdate'] = "?";
			$manniversary['Years'] = "";
			$mediaPath1 = "";
		}

		
		if (!$familyPrivacy && $personPrivacy2) {
			$manniversary['firstname2'] = 'Private:';
			$manniversary['lastname2'] = ' Details withheld';
			$manniversary['marrdate'] = "?";
			$manniversary['Years'] = "";
			$mediaPath2 = "";
		}
	if (!$divorceDate) {
	?>
		<tr>
			<td style="text-align: center"><div>
			<?php if ($dmedia1['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath1";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?>
			<br />
			<a href="/family/?personId=<?php echo $manniversary['personid1'];?>">
			<?php echo $manniversary['firstname1']; ?><?php echo $manniversary['lastname1']; ?></a></div></td>
			
			<td style="text-align: center"><div>
			<?php if ($dmedia2['thumbpath']) { ?>
			<img src="<?php 
			echo "$mediaPath2";  ?>" border='1' height='50' border-color='#000000'/> <?php } ?>
			<br />
			
			<a href="/family/?personId=<?php echo $manniversary['personid2'];?>">
			<?php echo $manniversary['firstname2']; ?><?php echo $manniversary['lastname2']; ?></a></div></td>
				
			<td style="text-align: center"><?php echo $manniversary['marrdate']; ?></a></td>
			
			
			
			<td style="text-align: center"><?php echo $manniversary['marrplace']; ?></td>
			<td style="text-align: center"><?php echo $manniversary['Years']; ?></td>
		</tr>
<?php 
		}
		endforeach; 

?>
	</tbody>
</table>
