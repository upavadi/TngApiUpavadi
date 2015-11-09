<?php

class TngApiCustom_Shortcode_ManniversariesPlusOne extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_manniversariesplusone';

    public function show()
    {
        //$this->content->init();

        $month = date('m');
        $manniversariesplusone = $this->custom->getMarriageAnniversariesPlusOne($month);
        // Get Media
		$url = $this->content->getTngUrl();
		$photos = $this->content->getTngPhotoFolder();
		$photosPath = $url. $photos;
		
        //get and hold current user
		$currentperson = $this->content->getCurrentPersonId($person['personID']);
        $context = array(
            'month' => $month,
			'gedcom' => $tree,
			'personid' => $personId,
            'manniversariesplusone' => $manniversariesplusone,
            'date' => date('F Y', strtotime('+1 month')),
			'currentperson' => $currentperson,
			'photosPath' => $photosPath
			
        );
        return $this->templates->render('m-anniversariesplusone.html', $context);
    }
}
