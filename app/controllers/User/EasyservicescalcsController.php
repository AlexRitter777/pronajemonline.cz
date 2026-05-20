<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\Models\Easyservicescalc;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;

class EasyservicescalcsController extends AppController
{

    #[inject]
    private Easyservicescalc $easyservicescalc;

    #[inject]
    private DeleteCalculationService $deleteCalculationService;

    public function destroyAction(){

        $recordDeleted = $this->deleteCalculationService->deleteCalculation('easyservicescalc', $this->easyservicescalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/calculations?calc_type=easyservicescalc');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }

    }




}