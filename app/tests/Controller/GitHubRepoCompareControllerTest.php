<?php

declare(strict_types=1);

namespace App\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class GitHubRepoCompareControllerTest extends TestCase
{
    public function testExample(): void
    {
        $controller = new GitHubRepoCompareController();
        // we have to mock container for controllers
        $container = $this->createMock(ContainerInterface::class);
        $controller->setContainer($container);

        $actual = $controller->index(1, 2);

        static::assertStringContainsString('You are going to compare 1 and 2', $actual->getContent());
    }
}