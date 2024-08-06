<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\ArticleNotFoundException;
use App\Services\ArticleService;
use Cake\View\JsonView;
use Cake\Datasource\Exception\RecordNotFoundException;
use App\Repository\ArticlesRepository;
use App\Exceptions\ValidationException;

use Exception;


class ArticlesController extends AppController
{

    protected ArticleService $articleService;
    protected ArticlesRepository $articlesRepository;


    public function initialize(): void
    {
        parent::initialize();

        $this->articlesRepository = new ArticlesRepository($this->Articles);
        $this->articleService = new ArticleService(
            new ArticlesRepository($this->Articles)
        );
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
            return $this->articleService->createArticle($articleData);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
        }
    }



    public function view(string $articleId)
    {
        $this->request->allowMethod(['GET']);

        try {
            return $this->articleService->viewArticleWithId($articleId);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
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
        $userId = $this->request->getAttribute('user');


        if (is_null($userId)) {
            $error = [
                'message' => 'Usuario não esta authenticado',
            ];

            $this->response = $this->response->withStatus(401)
                ->withType('application/json')
                ->withStringBody(json_encode($error));

            return $this->response;
        }

        try {
            $this->articlesRepository->deleteArticleWithId($articleId, $userId);
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
            } else if ($err instanceof ArticleNotFoundException) {
                $error = [
                    'message' => $err->getMessage(),
                ];

                $httpStatusCode = 404;
            }

            $this->response = $this->response->withStatus($httpStatusCode);

            $this->set('error', $error);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }

    }
}
