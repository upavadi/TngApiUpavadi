<?php

class TngApiCustom_Shortcode_BirthdaysPlusOne extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_birthdaysplusone';

    public function show()
    {
        //$this->content->init();

        $month = date('m');
        $birthdaysplusone = $this->custom->getBirthdaysPlusOne($month);
        
        //get and hold current user
		$currentperson = $this->content->getCurrentPersonId($person['personID']);
        $context = array(
            'month' => $month,
            'birthdaysplusone' => $birthdaysplusone,
            'date' => date('F Y', strtotime('+1 month')),
			'currentperson' => $currentperson
        );
        return $this->templates->render('birthdaysplusone.html', $context);
    }
}
