<?php

namespace app\controllers;

class ContactController extends AppController {

    public function indexAction()
    {
        unset($_SESSION['messageSent']);
        $this->setMeta('Kontaktujte nás | pronajemonline.cz - Formulář pro kontakt a podporu', 'V případě, že máte nějaké dotazy ohledně správy nemovitosti nebo pronájmu, a také vyúčtování služeb nájemníkům, neváhejte nás kontaktovat prostřednictvím kontaktního formuláře.');
        $this->layout = 'pronajemform';

    }

    public function newmessageAction()
    {
        $this->view = 'index';
        $this->setMeta('Kontaktujte nás | pronajemonline.cz', 'Formulář pro kontakt a podporu' );
        $this->layout = 'pronajemform';

    }


}