<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\Models\Universalcalc;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;

class UniversalcalcsController extends AppController
{
    #[inject]
    private Universalcalc $universalcalc;


    #[inject]
    private DeleteCalculationService $deleteCalculationService;


    public function destroyAction(){

        $recordDeleted = $this->deleteCalculationService->deleteCalculation('universalcalc', $this->universalcalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/calculations?calc_type=universalcalc');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }

    }

}