<?php

class TngApiCustom_Shortcode_DanniversariesPlusOne extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_pages_danniversariesplusone';

    public function show()
    {
        //$this->content->init();

        $month = date('m');
        $danniversariesplusone = $this->custom->getDeathAnniversariesPlusOne($month);
        
        //get and hold current user
		$currentperson = $this->content->getCurrentPersonId($person['personID']);
        $context = array(
            'month' => $month,
            'danniversariesplusone' => $danniversariesplusone,
            'date' => date('F Y', strtotime('+1 month')),
			'currentperson' => $currentperson
        );
        return $this->templates->render('d-anniversariesplusone.html', $context);
    }
}
