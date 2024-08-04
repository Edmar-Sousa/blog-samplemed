<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;


class ArticlesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }


    public function viewClasses(): array
    {
        return [JsonView::class];
    }


    public function add()
    {

    }

}
