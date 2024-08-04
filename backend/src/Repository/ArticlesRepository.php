<?php declare(strict_types=1);

namespace App\Repository;

use App\Model\Table\ArticlesTable;

class ArticlesRepository
{
    protected ArticlesTable $articlesTable;


    public function __construct(ArticlesTable $articlesTable)
    {
        $this->articlesTable = $articlesTable;
    }



}
