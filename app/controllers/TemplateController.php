<?php

namespace app\controllers;

class TemplateController extends AppController
{

    /**
     * Receive ajax request from js ModalBox class instance
     * Return Modal window template html code
     *
     * @throws \Exception
     */
    public function getajaxtemplateAction(){

        if(!empty($_POST['template_name'])) {

            $templateName = $_POST['template_name'];


            $modalTemplateFile = APP . "/views/modal_templates/{$templateName}.php";
            if (is_file($modalTemplateFile)) {
                ob_start();
                require_once $modalTemplateFile;
                echo ob_get_clean();
                die();
            } else {
                throw new \Exception("Modal template {$modalTemplateFile} is not found!", 404);
            }
        }

        throw new \Exception("Internal server error!", 500);

    }








}