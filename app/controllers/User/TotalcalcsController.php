<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;

class TotalcalcsController extends AppController
{

    #[Inject]
    private Totalcalc $totalcalc;

    #[Inject]
    private DeleteCalculationService $deleteCalculationService;


    public function destroyAction(){
        $recordDeleted = $this->deleteCalculationService->deleteCalculation('totalcalc', $this->totalcalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/calculations?calc_type=totalcalc');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }
    }

}