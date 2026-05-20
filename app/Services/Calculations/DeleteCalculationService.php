<?php

namespace app\services\Calculations;

use pronajem\libs\CSRF;

class DeleteCalculationService
{

    public function deleteCalculation(string $calculationType, object $calculation)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/calculations');
        }

        if (empty($_POST['token']) || !CSRF::checkCsrfToken($_POST['token'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/calculations');
        }


        if(empty($_POST[$calculationType])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/calculations');
        }

        $userId = $_SESSION['user_id'];

        $calculationID = $_POST[$calculationType];

        return $calculation->deleteOneRecordbyIdAndUserId($calculationID, $userId);


    }

}