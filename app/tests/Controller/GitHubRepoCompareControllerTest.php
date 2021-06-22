<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\GitHub\GitHubApi;
use PHPUnit\Framework\TestCase;
use App\Comparer\RepositoryComparer;
use App\Tests\Helpers\GitHubRepositoryTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GitHubRepoCompareControllerTest extends TestCase
{
    use GitHubRepositoryTrait;

    /**
     * @dataProvider getTestRequestData
     */
    public function testControllerRepositoryCompare(array $repos): void
    {
        $api = $this->createMock(GitHubApi::class);
        $api->method('getRepository')
            ->willReturnCallback(fn(string $repo) => $this->mockRepository(['name' => $repo]));

        $comparer = $this->createMock(RepositoryComparer::class);
        $comparer->method('toJson')
            ->with(\array_map(
                fn(string $repo) => $this->mockRepository(['name' => $repo]),
                $repos
            ))
            ->willReturn(['some' => 'json']);

        $controller = new GitHubRepoCompareController($api, $comparer);
        // we have to mock container for controllers
        $container = $this->createMock(ContainerInterface::class);
        $controller->setContainer($container);

        $request = $this->createMock(Request::class);
        $request->method('get')
            ->with('repositories')
            ->willReturn($repos);

        $actual = $controller->index($request);

        static::assertEquals(
            new JsonResponse(['some' => 'json']),
            $actual
        );
    }

    public function getTestRequestData(): array
    {
        return [
            [
                ['test/test', 'another/test']
            ]
        ];
    }
}