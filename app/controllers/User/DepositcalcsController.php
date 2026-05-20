<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\Models\Depositcalc;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;

class DepositcalcsController extends AppController
{

    #[inject]
    private Depositcalc $depositcalc;

    #[inject]
    private DeleteCalculationService $deleteCalculationService;


    public function destroyAction(){

        $recordDeleted = $this->deleteCalculationService->deleteCalculation('depositcalc', $this->depositcalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/calculations?calc_type=depositcalc');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }

    }

}