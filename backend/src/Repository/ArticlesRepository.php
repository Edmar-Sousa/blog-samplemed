<?php declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\ValidationException;
use App\Model\Entity\Article;
use App\Model\Table\ArticlesTable;

class ArticlesRepository
{
    protected ArticlesTable $articlesTable;


    public function __construct(ArticlesTable $articlesTable)
    {
        $this->articlesTable = $articlesTable;
    }



    public function saveArticle(array $articleData): Article
    {
        $articleEntity = $this->articlesTable->newEntity($articleData);

        if (!$this->articlesTable->save($articleEntity))
            throw new ValidationException('Erro ao criar o artigo', $articleEntity->getErrors());


        return $articleEntity;
    }


    public function getArticleWithId(string $articleId): Article
    {
        return $this->articlesTable->get($articleId);
    }

}
