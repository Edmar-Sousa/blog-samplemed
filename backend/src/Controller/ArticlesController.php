<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;
use Cake\Datasource\Exception\RecordNotFoundException;
use App\Repository\ArticlesRepository;
use App\Exceptions\ValidationException;

use Exception;


class ArticlesController extends AppController
{

    protected ArticlesRepository $articlesRepository;


    public function initialize(): void
    {
        parent::initialize();
        $this->articlesRepository = new ArticlesRepository($this->Articles);
    }


    public function viewClasses(): array
    {
        return [JsonView::class];
    }


    public function add()
    {
        $this->request->allowMethod(['POST']);

        try {

            $articleData = $this->request->getData();

            $article = $this->articlesRepository->saveArticle($articleData);

            $locationHeader = url([
                'action' => 'view',
                'id' => $article->id,
                '_ext' => 'json',
                'fullBase' => true
            ]);


            $this->response = $this->response->withStatus(201)
                ->withAddedHeader('Location', $locationHeader);

            $this->set('article', $article);
            $this->viewBuilder()->setOption('serialize', ['article']);
        } catch (Exception $err) {
            $error = [
                'message' => 'Erro interno no servidor'
            ];

            $httpStatusCode = 500;

            if ($err instanceof ValidationException) {
                $error = [
                    'message' => $err->getMessage(),
                    'details' => $err->getErrorsMessage(),
                ];

                $httpStatusCode = 400;
            }

            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }
    }



    public function view(string $articleId)
    {
        $this->request->allowMethod(['GET']);

        try {
            $article = $this->articlesRepository->getArticleWithId($articleId);

            $this->set('article', $article);
            $this->viewBuilder()->setOption('serialize', ['article']);
        } catch (Exception $err) {
            $error = [
                'message' => 'Error interno no servidor',
            ];

            $httpStatusCode = 500;

            if ($err instanceof RecordNotFoundException) {
                $error = [
                    'message' => 'Artigo não encontrado',
                ];

                $httpStatusCode = 404;
            }


            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }
    }


    public function edit(string $articleId)
    {
        $this->request->allowMethod(['PUT']);

        try {
            $articleData = $this->request->getData();
            $article = $this->articlesRepository->updateArticleWithId($articleId, $articleData);

            $this->set('article', $article);
            $this->viewBuilder()->setOption('serialize', ['article']);
        } catch (Exception $err) {

            $error = [
                'message' => 'Error interno no servidor',
            ];

            $httpStatusCode = 500;

            if ($err instanceof ValidationException) {
                $error = [
                    'message' => $err->getMessage(),
                    'details' => $err->getErrorsMessage(),
                ];

                $httpStatusCode = 400;

            } else if ($err instanceof RecordNotFoundException) {
                $error = [
                    'message' => 'Artigo não encontrado',
                ];

                $httpStatusCode = 404;
            }

            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }

    }


    public function delete(string $articleId)
    {

        $this->request->allowMethod(['DELETE']);

        try {
            $this->articlesRepository->deleteArticleWithId($articleId);
            $this->response = $this->response->withStatus(204);

            return $this->response;
        } catch (Exception $err) {

            $error = [
                'message' => 'Error interno no servidor'
            ];

            $httpStatusCode = 500;

            if ($err instanceof RecordNotFoundException) {
                $error = [
                    'message' => 'Artigo não encontrado',
                ];

                $httpStatusCode = 404;
            }

            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }

    }
}
