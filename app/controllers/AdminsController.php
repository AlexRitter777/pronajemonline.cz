<?php

namespace app\controllers;

use app\actions\Admin\CreateAdminAction;
use app\actions\Admin\DestroyAdminAction;
use app\actions\Admin\UpdateAdminAction;
use app\Exceptions\PersonNotFoundException;
use app\Exceptions\RecordNotCreatedException;
use app\Exceptions\RecordNotUpdatedException;
use app\Factories\AdminDataFactory;
use app\Models\Admin;
use app\Support\Account;
use app\validation\Core\ErrorBag;
use app\validation\Validators\AdminValidator;
use DI\Attribute\Inject;
use pronajem\base\Controller;
use pronajem\libs\CSRF;
use RedBeanPHP\R;

class AdminsController extends Controller
{
    #[Inject]
    private Account $accountModel;

    #[Inject]
    private Admin $admin;

    #[Inject]
    private ErrorBag $errorBag;

    #[Inject]
    private AdminValidator $validator;

    #[Inject]
    private AdminDataFactory $adminDataFactory;

    #[Inject]
    private CreateAdminAction $createAdminAction;

    #[Inject]
    private UpdateAdminAction $updateAdminAction;

    #[Inject]
    private DestroyAdminAction $destroyAdminAction;

    public function index()
    {
        $userId = $_SESSION['user_id'];

        $this->setMeta('Správci', 'Seznam správců');

        $result = $this->admin->getPaginatedRecords(10, null, [], $userId);

        $admins = $result->records;
        $pagination = $result->pagination;
        $token = CSRF::createCsrfToken();

        $this->set(compact('admins', 'pagination', 'token'));
    }

    public function show(int $adminId)
    {
        $userId = $_SESSION['user_id'];

        $admin = $this->admin->getOneRecordById($adminId, $userId);

        if (!$admin) {
            flash('error', 'Nepodařilo se najít správce!', 'error');
            redirect();
        }

        $propertyList = $this->accountModel->propertyList($admin->id, 'admin');
        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($admin->name, 'Profil správce');
        $this->set(compact('admin', 'propertyList', 'tokenInput'));
    }

    public function create()
    {
        [$errors, $old] = $this->errorBag->getErrors();
        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta('Nový správce', 'Vytvoření nového správce');
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
        $adminDto = $this->adminDataFactory->createFromArray($data);
        $adminId = $this->createAdminAction->execute($adminDto, $userId);

        flash('success', 'Správce byl úspěšně vytvořen.', 'success');
        redirect("/admins/{$adminId}");
    }

    public function edit(int $adminId)
    {
        [$errors, $old] = $this->errorBag->getErrors();
        $userId = $_SESSION['user_id'];

        $admin = $this->admin->getOneRecordById($adminId, $userId);

        if (!$admin) {
            flash('error', 'Nepodařilo se najít správce!', 'error');
            redirect();
        }

        $tokenInput = CSRF::createCsrfInput();

        $this->setMeta($admin->name . ' - editace', 'Profil správce');
        $this->set(compact('admin', 'tokenInput', 'errors', 'old'));
    }

    /**
     * @throws PersonNotFoundException
     * @throws RecordNotUpdatedException
     */
    public function update(int $adminId)
    {
        checkCsrfOrRedirect($_POST['token'] ?? '');

        $userId = $_SESSION['user_id'];
        $data = $this->validator->validate(sanitize($_POST));
        $adminDto = $this->adminDataFactory->createFromArray($data);

        try {
            $adminId = $this->updateAdminAction->execute($adminDto, $adminId, $userId);
            flash('success', 'Správce byl úspěšně upraven.', 'success');
            redirect("/admins/{$adminId}");
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect('/admins');
        }
    }

    public function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/admins');
        }

        checkCsrfOrRedirect($_POST['token'] ?? '');

        if (empty($_POST['admin'])) {
            flash('error', 'Něco se nepovedlo, zkuste to prosím znovu.', 'error');
            redirect('/admins');
        }

        $adminId = $_POST['admin'];
        $userId = $_SESSION['user_id'];

        try {
            $this->destroyAdminAction->execute($this->admin, $adminId, $userId);
            flash('success', 'Správce byl úspěšně smazán.', 'success');
            redirect('/admins');
        } catch (PersonNotFoundException $e) {
            flash('error', $e->getMessage(), 'error');
            redirect();
        }
    }

    public function getAdminList()
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            die();
        }

        $admins = R::getAll(
            'SELECT id, name FROM admin WHERE name LIKE :term AND user_id = :user_id',
            [
                ':term' => '%' . $term . '%',
                ':user_id' => $userId,
            ]
        );

        $result = [];

        foreach ($admins as $admin) {
            $result[] = [
                'id' => $admin['id'],
                'text' => $admin['name'],
            ];
        }

        echo json_encode($result);
        die();
    }

    /**
     * @throws RecordNotCreatedException
     */
    public function saveModal()
    {
        if (
            empty($_SERVER['HTTP_X_REQUESTED_WITH']) ||
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest' ||
            $_SERVER['REQUEST_METHOD'] !== 'POST'
        ) {
            redirect('/admins');
        }

        $data = sanitize($_POST);
        $userId = $_SESSION['user_id'];
        $adminDto = $this->adminDataFactory->createFromArray($data);
        $adminId = $this->createAdminAction->execute($adminDto, $userId);

        echo json_encode([
            'adminID' => $adminId,
            'adminName' => $adminDto->name,
        ]);
        die();
    }
}
