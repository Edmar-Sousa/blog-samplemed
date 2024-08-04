<?php
declare(strict_types=1);

namespace App\Controller;

use Exception;
use Cake\View\JsonView;
use App\Repository\UsersRepository;
use App\Exceptions\ValidationException;
use Cake\Datasource\Exception\RecordNotFoundException;


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

            $locationHeader = url([
                'action' => 'view',
                'id' => $user->id,
                '_ext' => 'json',
                'fullBase' => true
            ]);

            $this->response = $this->response
                ->withStatus(201)
                ->withAddedHeader('Location', $locationHeader);


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


    public function view(string $userId)
    {

        $this->request->allowMethod(['get']);


        try {
            $user = $this->usersRepository->findUserWithId($userId);

            $this->set('user', $user);
            $this->viewBuilder()->setOption('serialize', ['user']);
        } catch (Exception $err) {

            $error = [
                'message' => 'Erro interno do servidor',
            ];

            $statusHttpCode = 500;


            if ($err instanceof RecordNotFoundException) {
                $error = [
                    'message' => 'Usuario com id informado não existe',
                ];

                $statusHttpCode = 404;
            }


            $this->response = $this->response->withStatus($statusHttpCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }


    }


    public function edit(string $userId)
    {

        $this->request->allowMethod('PUT');


        try {
            $userData = $this->request->getData();
            $user = $this->usersRepository->updateUserWithId($userId, $userData);

            $this->set('user', $user);
            $this->viewBuilder()->setOption('serialize', ['user']);
        } catch (Exception $err) {

            $error = [
                'message' => 'Erro interno do servidor',
            ];

            $statusHttpCode = 500;


            if ($err instanceof RecordNotFoundException) {
                $error = [
                    'message' => 'Usuario com id informado não existe',
                ];

                $statusHttpCode = 404;
            } else if ($err instanceof ValidationException) {
                $error = [
                    'message' => $err->getMessage(),
                    'details' => $err->getValidationMessages(),
                ];

                $statusHttpCode = 400;
            }


            $this->response = $this->response->withStatus($statusHttpCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }

    }

}
