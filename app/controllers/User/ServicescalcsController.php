<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\Models\Servicescalc;
use app\services\Calculations\DeleteCalculationService;
use DI\Attribute\Inject;
use pronajem\libs\CSRF;

class ServicescalcsController extends AppController
{

    #[inject]
    private Servicescalc $servicescalc;

    #[inject]
    private DeleteCalculationService $deleteCalculationService;


    /**
     * New services settlement form
     */
    public function createAction()
    {

        $this->setMeta('Vyúčtování služeb', 'Vytvořte nové vyúčtování služeb spojených s užíváním bytu.');
        $this->layout = 'account';
        $data = null;
        $reCaptcha = false;

        $this->set(compact('data', 'reCaptcha'));

    }


    public function destroyAction()
    {
        $recordDeleted = $this->deleteCalculationService->deleteCalculation('servicescalc', $this->servicescalc);

        if($recordDeleted){
            flash('success', 'Vyúčtování bylo úspěšně smazáno.', 'success');
            redirect('/calculations');
        } else {
            flash('error', 'Nepodařilo se najít vyúčtování!', 'error');
            redirect();
        }

    }

}