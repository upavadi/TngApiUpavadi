<?php

class TngApiCustom_Shortcode_BirthdaysCustom extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_birthdayscustom';

    public function show()
    {	
		$currentPersonId = $this->content->getCurrentPersonId();
        
		$currentperson = $this->content->getCurrentPersonId($person['personID']);
		$currentperson = $this->content->getPerson($currentperson);
		$currentuser = ($currentperson['firstname'] ." ". $currentperson['lastname']);
		$monthyear = filter_input(INPUT_GET, 'monthyear', FILTER_SANITIZE_SPECIAL_CHARS);
		$user = $this->content->getTngUser();
		$userBranch = $user['description'];
		
		if ($monthyear == "") {
            $month = date('m');
            $year = date('Y');
			
        } else {
            $month = substr($monthyear, 3, 2);
            $year = substr($monthyear, 6, 4);
        }
		$currentDay = date('d');
		$currentMonth= date('m');
        $birthdaysBranch = $this->getCustomBirthdays($month);
        // Get Media
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
			'currentPersonId' => $currentPersonId,
            'birthdaysBranch' => $birthdaysBranch,
            'date' => $date,
			'currentperson' => $currentuser,
			'dmedia' => $dmedia,
			'photosPath' => $photosPath,
			'mediaPath' => $mediaPath,
			'branch' => $userBranch
        );

        return $this->templates->render('birthdayscustom.html', $context);
    }
	public function getCustomBirthdays($month)
    {
        $tables = $this->content->getTngTables();
		$user = $this->content->getTngUser();
		$userBranch = $user['description'];
		$newDate = date('Y', strtotime('month'));
$sql = <<<SQL
SELECT a.persfamID AS persfamID1,
		b.personID aS personID1,
		b.firstname,
       b.lastname,
       b.birthdate,
	   b.birthdatetr,
       b.birthplace,
	   b.private,
	   b.living,
       b.gedcom
	   

	FROM   {$tables['branchlinks_table']} AS a
    LEFT JOIN {$tables['people_table']} AS b
    ON a.persfamID = b.personID
    WHERE a.branch = '$userBranch' AND a.persfamID LIKE "I%" 
	AND Month(b.birthdatetr) = {$month}	
	ORDER  BY Day(b.birthdatetr),
          b.lastname



SQL;
        $result = $this->custom->query($sql);
		
		$rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
		
        return $rows;
    }
	
	public function getTngTables()
	{
		return $this->content->getTngTables();
	}

	
	
}
