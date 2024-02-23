<?php

namespace app\models;

use mysql_xdevapi\Exception;

class ReCaptcha extends AppModel {

    public $success;

    public function recaptchaValidate ($captcha, $secretKey) {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array('secret' => $secretKey, 'response' => $captcha);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response,true);
        //header('Content-type: application/json');
        if($responseKeys["success"] && $responseKeys['score'] > 0.5) {
            $this->success = true;
        }
    }




}