<?php

class TngApiCustom_Shortcode_DanniversariesPlusOne extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_danniversariesplusone';

    public function show()
    {
        //$this->content->init();
		$month = date('m') +1;
        $danniversariesplusone = $this->custom->getDeathAnniversariesPlusOne($month);
        // Get Media
        $url = $this->content->getTngUrl();
        $tngFolder = $this->content->getTngIntegrationPath();
		$photos = $this->content->getTngPhotoFolder();
		$photosPath = $url. $photos;
		//get and hold current user
		$currentperson = $this->content->getCurrentPersonId($person['personID']);
        $context = array(
            'month' => $month,
            'danniversariesplusone' => $danniversariesplusone,
			'gedcom' => $tree,
			'personid' => $personId,
            'date' => date('F Y', strtotime('+1 month')),
            'currentperson' => $currentperson,
            'tngFolder' => $tngFolder,
			'photosPath' => $photosPath
			
        );
        return $this->templates->render('d-anniversariesplusone.html', $context);
    }
}
