<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagsFixture
 */
class TagsFixture extends TestFixture
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
                'id' => 'd9010f73-7267-4684-a48d-b92426462644',
                'title' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
