<?php

namespace app\controllers;

use app\actions\Elsupplier\CreateElsupplierAction;
use app\actions\Elsupplier\DestroyElsupplierAction;
use app\actions\Elsupplier\UpdateElsupplierAction;
use app\Exceptions\PersonNotFoundException;
use app\Exceptions\RecordNotCreatedException;
use app\Exceptions\RecordNotUpdatedException;
use app\Factories\ElsupplierDataFactory;
use app\Models\Elsupplier;
use app\Support\Account;
use app\validation\Core\ErrorBag;
use app\validation\Validators\ElsupplierValidator;
use DI\Attribute\Inject;
use pronajem\base\Controller;
use pronajem\libs\CSRF;
use RedBeanPHP\R;

class ElsuppliersController extends Controller
{
    #[Inject]
    private Account $accountModel;

    #[Inject]
    private Elsupplier $elsupplier;

    #[Inject]
    private ErrorBag $errorBag;

    #[Inject]
    private ElsupplierValidator $validator;

    #[Inject]
    private ElsupplierDataFactory $elsupplierDataFactory;

    #[Inject]
    private CreateElsupplierAction $createElsupplierAction;

    #[Inject]
    private UpdateElsupplierAction $updateElsupplierAction;

    #[Inject]
    private DestroyElsupplierAction $destroyElsupplierAction;

    public function index()
    {
        $userId = $_SESSION['user_id'];

        $this->setMeta('Dodavatelé elektřiny', 'Seznam dodavatelů elektřiny');

        $result = $this->elsupplier->getPaginatedRecords(10, null, [], $userId);

        $elsuppliers = $result->records;
        $pagination = $result->pagination;
        $token = CSRF::createCsrfToken();

        $this->set(compact('elsuppliers', 'pagination', 'token'));
    }

    public function show(int $elsupplierId)
    {
        $userId = $_SESSION['user_id'];

        $elsupplier = $this->elsupplier->getOneRecordById($elsupplierId, $userId);

        if (!$elsupplier) {
            flash('error', 'Nepodařilo se najít dodavatele elektřiny!', 'error');
            redirect();
        }

        $propertyList = $this->accountModel->propertyList($elsupplier->id, 'elsupplier');
        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($elsupplier->name, 'Profil dodavatele elektřiny');
        $this->set(compact('elsupplier', 'propertyList', 'tokenInput'));
    }

    public function create()
    {
        [$errors, $old] = $this->errorBag->getErrors();
        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta('Nový dodavatel elektřiny', 'Založení nového dodavatele elektřiny');
        $this->set(compact('tokenInput', 'errors', 'old'));
    }

    /**
     * @throws RecordNotCreatedException
     */
    public function store()
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');

        $data = $this->validator->validate(sanitize($_POST));
        $userId = $_SESSION['user_id'];
        $elsupplierDto = $this->elsupplierDataFactory->createFromArray($data);
        $elsupplierId = $this->createElsupplierAction->execute($elsupplierDto, $userId);

        flash('success', 'Dodavatel elektřiny byl úspěšně vytvořen.', 'success');
        redirect("/elsuppliers/{$elsupplierId}");
    }

    public function edit(int $elsupplierId)
    {
        [$errors, $old] = $this->errorBag->getErrors();
        $userId = $_SESSION['user_id'];

        $elsupplier = $this->elsupplier->getOneRecordById($elsupplierId, $userId);

        if (!$elsupplier) {
            flash('error', 'Nepodařilo se najít dodavatele elektřiny!', 'error');
            redirect();
        }

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($elsupplier->name . ' - editace', 'Profil dodavatele elektřiny');
        $this->set(compact('elsupplier', 'tokenInput', 'errors', 'old'));
    }

    /**
     * @throws PersonNotFoundException
     * @throws RecordNotUpdatedException
     */
    public function update(int $elsupplierId)
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');

        $userId = $_SESSION['user_id'];
        $data = $this->validator->validate(sanitize($_POST));
        $elsupplierDto = $this->elsupplierDataFactory->createFromArray($data);

        try {
            $elsupplierId = $this->updateElsupplierAction->execute($elsupplierDto, $elsupplierId, $userId);
            flash('success', 'Dodavatel elektřiny byl úspěšně upraven.', 'success');
            redirect("/elsuppliers/{$elsupplierId}");
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect('/elsuppliers');
        }
    }

    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/elsuppliers');
        }

        checkCsrfOrRedirect($_POST['token'] ?? '');

        if (empty($_POST['elsupplier'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/elsuppliers');
        }

        $elsupplierId = $_POST['elsupplier'];
        $userId = $_SESSION['user_id'];

        try {
            $this->destroyElsupplierAction->execute($this->elsupplier, $elsupplierId, $userId);
            flash('success', 'Dodavatel elektřiny byl úspěšně smazán.', 'success');
            redirect('/elsuppliers');
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect();
        }
    }

    public function getElsupplierList()
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            die();
        }

        $elsuppliers = R::getAll(
            'SELECT id, name FROM elsupplier WHERE name LIKE :term AND user_id = :user_id',
            [
                ':term' => '%' . $term . '%',
                ':user_id' => $userId,
            ]
        );

        $result = [];

        foreach ($elsuppliers as $elsupplier) {
            $result[] = [
                'id' => $elsupplier['id'],
                'text' => $elsupplier['name'],
            ];
        }

        echo json_encode($result);
        die();
    }
}
