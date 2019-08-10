<?php

class TngApiCustom_TngCustom extends Upavadi_TngCustomContent
{

    protected $shortCodes = array(
        "MyShortcode",
        "LandingPage",
		"BirthdaysPlusOne",
		"ManniversariesPlusOne",
		"DanniversariesPlusOne",
		"FamilySheet",
		"BirthdaysCustom",
		"ManniversariesCustom",
		"DanniversariesCustom"
		
		
    );

    public function __construct(Upavadi_TngContent $content)
    {
        parent::__construct($content, __FILE__);
    }

    public function getPersonName($personId)
    {
        $person = $this->content->getPerson($personId);
        $name = $person['firstname'] . $person['lastname'];

        return $name;
    }

    public function getBirthdaysPlusOne($month)
    {
        $tables = $this->content->getTngTables();
		$newDate = date('Y', strtotime('+1 month'));
		$sql = <<<SQL
SELECT personid,
       firstname,
       lastname,
       birthdate,
       birthplace,
       gedcom,
       "$newDate" - Year(birthdatetr) AS Age
FROM   {$tables['people_table']}
WHERE  Month(birthdatetr) = MONTH(ADDDATE(now(), INTERVAL 1 month))
       AND living = 1
ORDER  BY Day(birthdatetr),
          lastname
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getCurrentBirthday()
    {
        $tables = $this->content->getTngTables();

        $sql = <<<SQL
SELECT personid,
       firstname,
       lastname,
       birthdate,
       birthplace,
       gedcom,
       Year(Now()) - Year(birthdatetr) AS Age
FROM   {$tables['people_table']}
WHERE
    DATE(CONCAT(YEAR(CURDATE()), RIGHT(birthdatetr, 6)))
        BETWEEN 
            DATE_SUB(CURDATE(), INTERVAL 1 DAY)
        AND
            DATE_ADD(CURDATE(), INTERVAL 1 DAY)
       AND living = 1
ORDER BY
    month(birthdatetr),
    Day(birthdatetr),
    lastname
SQL;

        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getCurrentMAnniversaries()
    {
        $tables = $this->content->getTngTables();
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
       f.divdate,
       Year(Now()) - Year(marrdatetr) AS Years
FROM   {$tables['families_table']} as f
    LEFT JOIN {$tables['people_table']} AS h
              ON f.husband = h.personid
       LEFT JOIN {$tables['people_table']} AS w
              ON f.wife = w.personid
# WHERE  Month(f.marrdatetr) = MONTH(ADDDATE(now(), INTERVAL 3 month))
  WHERE  DATE(CONCAT(YEAR(CURDATE()), RIGHT(f.marrdatetr, 6)))
          BETWEEN 
              DATE_SUB(CURDATE(), INTERVAL 1 DAY)
          AND
              DATE_ADD(CURDATE(), INTERVAL 1 DAY)     
ORDER  BY Day(f.marrdatetr)
          
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

	
    public function getMarriageAnniversariesPlusOne($month)
    {
		$tables = $this->content->getTngTables();
		$newDate = date('Y', strtotime('+1 month'));
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
       f.divdate,
       "$newDate" - Year(marrdatetr) AS Years
FROM   {$tables['families_table']} as f
    LEFT JOIN {$tables['people_table']} AS h
              ON f.husband = h.personid
       LEFT JOIN {$tables['people_table']} AS w
              ON f.wife = w.personid
WHERE  Month(f.marrdatetr) = MONTH(ADDDATE(now(), INTERVAL 1 month))
       
ORDER  BY Day(f.marrdatetr)
          
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getCurrentDAnniversaries()
    {
        $tables = $this->content->getTngTables();
        $sql = <<<SQL
SELECT personid,
       firstname,
       lastname,
       deathdate,
       deathplace,
       gedcom,
       Year(Now()) - Year(deathdatetr) AS Years
FROM   {$tables['people_table']}
WHERE  DATE(CONCAT(YEAR(CURDATE()), RIGHT(deathdatetr, 6)))
          BETWEEN 
              DATE_SUB(CURDATE(), INTERVAL 1 DAY)
          AND
              DATE_ADD(CURDATE(), INTERVAL 1 DAY)
       AND living = 0
ORDER  BY month(deathdatetr),
			Day(deathdatetr),
          lastname
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
	
	
		public function getDeathAnniversariesPlusOne($month)
    {
        $tables = $this->content->getTngTables();
		
		$newDate = date('Y', strtotime('+1 month'));
		$sql = <<<SQL
SELECT personid,
       firstname,
       lastname,
	   birthdate,
	   birthdatetr,
       deathdate,
	   deathdatetr,
       deathplace,
       gedcom,
       "$newDate" - Year(deathdatetr) AS Years
FROM   {$tables['people_table']}
WHERE  Month(deathdatetr) = MONTH(ADDDATE(now(), INTERVAL 1 month))
       AND living = 0
ORDER  BY Day(deathdatetr),
          lastname
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
	public function getmemberid()
	{	
	$memberdb = new wpdb($DB_USER, $DB_PASSWORD, $DB_HOST);
    $memberdb ->show_errors;
	
	}
public function getTngUrl($url)
    {
        $url = esc_attr(get_option('tng-api-tng-url'));
		return $url;
    
	}
 public function getDefaultMedia($personId = null)
    {

        if (!$personId) {
            $personId = $this->currentPerson;
        }
        $user = $this->getTngUser();
        $userPrivate = $user['allow_private'];
        $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
       
        $person = $this->getPerson($personId, $gedcom);
        $personPrivate = $person['private'];

        if ($personPrivate > $userPrivate) {
            return array();
        }
        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND m.gedcom = "' . $gedcom . '"';
        }
	$sql = <<<SQL
SELECT *
FROM   {$this->tables['media_table']} as ml
    LEFT JOIN {$this->tables['medialinks_table']} AS m
              ON ml.mediaID = m.mediaID
where personID = '{$personId}' AND m.defphoto = "1"
SQL;
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }
	
}
