<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\ValidationException;
use App\Repository\UsersRepository;
use Cake\View\JsonView;
use Exception;


class UsersController extends AppController
{

    protected UsersRepository $usersRepository;

    public function initialize(): void
    {
        parent::initialize();

        $this->usersRepository = new UsersRepository($this->Users);
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function add()
    {

        $this->request->allowMethod(['post']);


        try {

            $userData = $this->request->getData();
            $user = $this->usersRepository->saveUser($userData);

            $this->response = $this->response->withStatus(201);

            $this->set('user', $user);
            $this->viewBuilder()->setOption('serialize', ['user']);
        } catch (Exception $err) {

            $error = [
                'message' => 'Erro interno do servidor',
            ];

            $this->response = $this->response->withStatus(500);


            if ($err instanceof ValidationException) {
                $error = [
                    'message' => $err->getMessage(),
                    'details' => $err->getValidationMessages()
                ];

                $this->response = $this->response->withStatus(400);
            }

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }


    }

}
