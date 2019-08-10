<?php

class TngApiCustom_Shortcode_ManniversariesCustom extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_manniversariescustom';

    public function show()
    {
        $currentperson = $this->content->getCurrentPersonId($person['personID']);
		$currentperson = $this->content->getPerson($currentperson);
		$currentuser = ($currentperson['firstname'] ." ". $currentperson['lastname']);
		$monthyear = filter_input(INPUT_GET, 'monthyear', FILTER_SANITIZE_SPECIAL_CHARS);
		$user = $this->content->getTngUser();
		$userBranch = $user['branch'];
		
		if ($monthyear == "") {
            $month = date('m');
            $year = date('Y');
        } else {
            $month = substr($monthyear, 3, 2);
            $year = substr($monthyear, 6, 4);
        }
		$currentDay = date('d');
		$currentMonth= date('m');
		$manniversariesBranch = $this->getCustomMarriageAnniversaries($month);
		$url = $this->content->getTngUrl();
		$date = new DateTime();
        $date->setDate($year, $month, 01);	
		$photos = $this->content->getTngPhotoFolder();
		$photosPath = $url. $photos;
		$context = array(
             'year' => $year,
			'month' => $month,
			'currentDay' => $currentDay,
			'currentMonth' => $currentMonth,
			'gedcom' => $tree,
			'personid' => $personId,
            'manniversariesBranch' => $manniversariesBranch,
            'date' =>$date,
			'currentperson' => $currentuser,
			'photosPath' => $photosPath,
			'branch' => $userBranch
			
        );
        return $this->templates->render('m-anniversariescustom.html', $context);
    }
	
	public function getCustomMarriageAnniversaries($month)
    {
		$tables = $this->content->getTngTables();
		$user = $this->content->getTngUser();
		$userBranch = $user['branch'];
		
		$sql = <<<SQL
SELECT h.gedcom,
	   h.personid AS personid1,
       h.firstname AS firstname1,
       h.lastname AS lastname1,
       w.personid AS personid2,
       w.firstname AS firstname2,
       w.lastname AS lastname2,
	   f.familyID,
       f.marrdate,
       f.marrplace,
       Year(Now()) - Year(marrdatetr) AS Years
FROM
	{$tables['families_table']} as f
    LEFT JOIN {$tables['people_table']} AS h
		ON f.husband = h.personid
	LEFT JOIN {$tables['people_table']} AS w
		ON f.wife = w.personid
	LEFT JOIN {$tables['branchlinks_table']} AS bh
		ON f.husband = bh.persfamID
	LEFT JOIN {$tables['branchlinks_table']} AS bw
		ON f.wife = bw.persfamID	
WHERE  Month(f.marrdatetr) = {$month}	
       AND bh.branch = '$userBranch' AND bh.persfamID LIKE "I%" 
ORDER  BY Day(f.marrdatetr)
          
SQL;
        $result = $this->custom->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
}
