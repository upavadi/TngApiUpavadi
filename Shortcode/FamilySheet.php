<?php

class TngApiCustom_Shortcode_FamilySheet extends Upavadi_Shortcode_AbstractShortcode
{
    const SHORTCODE = 'tngcustom_familysheet';

    //do shortcode Add Family form
    public function show()
    {
        $personId = filter_input(INPUT_GET, 'personId', FILTER_SANITIZE_SPECIAL_CHARS);
        $context = array();
        $context['personId'] = $personId;
        return $this->templates->render('familysheet.html', $context);
    }
}