<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;


class UsersController extends AppController
{

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function add()
    {

        $this->request->allowMethod(['post']);


        $users = [
            'name' => 'Edinho',
            'email' => 'email@gmail.com',
        ];


        $this->set('user', $users);
        $this->viewBuilder()->setOption('serialize', ['user']);

    }

}
