<?php

namespace App\Controller;

use App\Comparer\ComparerInterface;
use App\Api\Types\RepositoryApiInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GitHubRepoCompareController extends AbstractController
{
    private RepositoryApiInterface $apiInterface;

    private ComparerInterface $comparer;

    public function __construct(RepositoryApiInterface $api, ComparerInterface $comparer)
    {
        $this->apiInterface = $api;
        $this->comparer = $comparer;
    }

    /**
     * todo swagger docs
     * @Route("/github/repository/compare", name="github.repository.compare")
     */
    public function index(Request $request): JsonResponse
    {
        $repositories = \array_map(
            function(string $repoName) {
                // todo it can be refactored
                $repo = $this->apiInterface->getRepository($repoName);

                $releases = $this->apiInterface->getRepositoryReleases($repoName);
                $repo->setLatestRelease($releases[0] ?? null);

                $pulls = $this->apiInterface->getPullRequests($repoName);
                $repo->setPullRequests($pulls);

                return $repo;
            }, 
            $request->get('repositories')
        );

        return $this->json($this->comparer->toJson($repositories));
    }
}
