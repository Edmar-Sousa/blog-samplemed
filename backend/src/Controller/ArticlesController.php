<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\ValidationException;
use Exception;
use Cake\View\JsonView;
use App\Repository\ArticlesRepository;


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



    public function view(string $id)
    {

    }
}
