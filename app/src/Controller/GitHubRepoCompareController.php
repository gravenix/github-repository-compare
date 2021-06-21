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
     * todo docs
     * @Route("/github/repository/compare", name="github.repository.compare")
     */
    public function index(Request $request): JsonResponse
    {
        $repositories = \array_map(
            fn(string $repo) => $this->apiInterface->getRepository($repo), 
            $request->get('repositories')
        );

        return $this->json($this->comparer->toJson($repositories));
    }
}
