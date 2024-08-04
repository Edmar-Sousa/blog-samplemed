<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArticlesTagsFixture
 */
class ArticlesTagsFixture extends TestFixture
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
                'id' => 'bbab0826-96b6-467d-aa5a-23efc13d0aa1',
                'article_id' => '18389c21-665a-4329-949c-80bb666d0e53',
                'tag_id' => 'c7a18263-35b2-4513-8544-d7c3522ffa82',
            ],
        ];
        parent::init();
    }
}
