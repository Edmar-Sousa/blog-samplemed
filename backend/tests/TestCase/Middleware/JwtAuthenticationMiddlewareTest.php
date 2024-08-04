<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\JwtAuthenticationMiddleware;
use Cake\TestSuite\TestCase;

/**
 * App\Middleware\JwtAuthenticationMiddleware Test Case
 */
class JwtAuthenticationMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Middleware\JwtAuthenticationMiddleware
     */
    protected $JwtAuthentication;

    /**
     * Test process method
     *
     * @return void
     * @uses \App\Middleware\JwtAuthenticationMiddleware::process()
     */
    public function testProcess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
