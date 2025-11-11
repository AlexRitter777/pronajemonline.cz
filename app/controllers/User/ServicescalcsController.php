<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\db_models\Servicescalc;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;
use pronajem\libs\CSRF;

class ServicescalcsController extends AppController
{

    #[inject]
    private Servicescalc $servicescalc;

    #[inject]
    private DeleteCalculationService $deleteCalculationService;

    public function destroyAction()
    {
        $recordDeleted = $this->deleteCalculationService->deleteCalculation('servicescalc', $this->servicescalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/user/calculations');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }

    }

}