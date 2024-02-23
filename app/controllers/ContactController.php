<?php

namespace app\controllers;

class ContactController extends AppController {

    public function indexAction()
    {
        unset($_SESSION['messageSent']);
        $this->setMeta('Kontakt', 'Kontaktní formulář ', 'kontakt, poslat zprávu, vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem');
        $this->layout = 'pronajemform';

    }

    public function newmessageAction()
    {
        $this->view = 'index';
        $this->setMeta('Kontakt', 'Kontaktní formulář ', 'kontakt, poslat zprávu, vyúčtování služeb, pronajímatel, nájemník, vyúčtování energii, vyúčtování kauce, pronájem');
        $this->layout = 'pronajemform';

    }


}