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

        $this->request->allowMethod(['POST']);


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

            $httpStatusCode = 500;


            if ($err instanceof ValidationException) {
                $error = [
                    'message' => $err->getMessage(),
                    'details' => $err->getValidationMessages()
                ];

                $httpStatusCode = 400;
            }

            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }


    }


    public function view(string $id)
    {

        $this->request->allowMethod(['GET']);


        try {
            $user = $this->usersRepository->findUserWithId($id);

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

        $this->request->allowMethod(['PUT']);


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


    public function delete(string $userId)
    {
        $this->request->allowMethod(['DELETE']);

        try {
            $this->usersRepository->deleteUserWithId($userId);
            $this->response = $this->response->withStatus(204);

            return $this->response;
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

}
