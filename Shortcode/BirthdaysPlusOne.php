<?php

class TngApiCustom_Shortcode_BirthdaysPlusOne extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_birthdaysplusone';

    public function show()
    {
        //$this->content->init();

        $month = date("m")+1;
        $birthdaysplusone = $this->custom->getBirthdaysPlusOne($month);
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
            'birthdaysplusone' => $birthdaysplusone,
            'date' => date('F Y', strtotime('+1 month')),
			'currentperson' => $currentperson,
			'dmedia' => $dmedia,
			'photosPath' => $photosPath,
			'mediaPath' => $mediaPath
        );
        return $this->templates->render('birthdaysplusone.html', $context);
    }
}
