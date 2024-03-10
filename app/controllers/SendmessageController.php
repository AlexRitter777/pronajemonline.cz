<?php

namespace app\controllers;

use app\models\SendMessage;
use pronajem\app;
use pronajem\libs\EmailSender;


class SendmessageController extends AppController {


    public function indexAction() {

        if (!isset($_SESSION['messageSent'])) {
            if (!empty($_POST)) {

                $contactName = $_POST['contactName'];
                $contactEmail = $_POST['contactEmail'];
                $contactMessage = $_POST['contactMessage'];

                //$sendMessage = new SendMessage();

                $email = app::$app->getProperty('info_email');

                EmailSender::sendEmail($email, 'Pronjemonline.cz - nová zpráva', 'contactform_newmessage_admin', compact('contactName','contactEmail','contactMessage'));
                $_SESSION['messageSent'] = true;



            } else {
                //throw new \Exception('Anything was wrong! Please try again later!');
                header('Location: /');
            }
        } else {
            unset($_SESSION['messageSent']);
            header('Location: /contact/new-message'); //Рабоать с этим!!!
        }


    }







}