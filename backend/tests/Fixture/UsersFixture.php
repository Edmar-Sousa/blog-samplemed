<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '798ce3f1-7cc7-4d37-a287-940413fc93ca',
                'username' => 'teste',
                'name' => 'Lorem ipsum dolor sit amet',
                'password' => '123',
                'email' => 'usertestemail@gmail.com',
                'created' => 1722775028,
                'modified' => 1722775028,
            ],
        ];
        parent::init();
    }
}
