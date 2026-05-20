<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\Models\Electrocalc;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;

class ElectrocalcsController extends AppController
{

    #[inject]
    private Electrocalc $electrocalc;


    #[inject]
    private DeleteCalculationService $deleteCalculationService;


    public function destroyAction(){

        $recordDeleted = $this->deleteCalculationService->deleteCalculation('electrocalc', $this->electrocalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/calculations?calc_type=electrocalc');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }

    }


}