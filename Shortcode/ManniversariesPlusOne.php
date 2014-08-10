<?php

class TngApiCustom_Shortcode_ManniversariesPlusOne extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_manniversariesplusone';

    public function show()
    {
        //$this->content->init();

        $month = date('m');
        $manniversariesplusone = $this->custom->getMarriageAnniversariesPlusOne($month);
        
        //get and hold current user
		$currentperson = $this->content->getCurrentPersonId($person['personID']);
        $context = array(
            'month' => $month,
            'manniversariesplusone' => $manniversariesplusone,
            'date' => date('F Y', strtotime('+1 month')),
			'currentperson' => $currentperson
        );
        return $this->templates->render('m-anniversariesplusone.html', $context);
    }
}
