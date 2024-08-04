<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Cake\View\JsonView;


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
    }

}
