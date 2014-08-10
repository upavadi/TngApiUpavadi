<?php

class TngApiCustom_Shortcode_LandingPage extends Upavadi_Shortcode_AbstractCustomShortcode
{
    const SHORTCODE = 'tngcustom_landing_page';
    
    public function show()
    {
        $personId = $this->content->getCurrentPersonId();
        $month = date('m');
        $context = array(
            'personId' => $personId,
            'name' => $this->custom->getPersonName($personId),
            'profileImage' => $this->content->getProfileMedia($personId),
            'birthdays' => $this->custom->getCurrentBirthday(),
            'manniversaries' => $this->custom->getCurrentMAnniversaries(),
            'danniversaries' => $this->custom->getCurrentDAnniversaries(),
            'date' => date("l, jS F Y")
        );
        return $this->templates->render('landing-page.html', $context);
    }
}
