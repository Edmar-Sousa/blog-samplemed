<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\ArticleNotFoundException;
use App\Services\ArticleService;
use Cake\Http\Response;
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
            $this->articleService->updateArticle($articleId, $articleData);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
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

            return $this->articleService->deleteArticle($articleId, $userId);

        } catch (Exception $err) {

            return $this->articleService->handlerException($err);
        }

    }
}
