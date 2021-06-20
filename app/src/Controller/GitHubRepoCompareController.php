<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GitHubRepoCompareController extends AbstractController
{
    /**
     * @Route("/github/repository/compare/{firstRepo}/{secondRepo}", name="github.repository.compare")
     */
    public function index(int $firstRepo, int $secondRepo): JsonResponse
    {
        return $this->json([
            'message' => "Welcome to your new controller! You are going to compare $firstRepo and $secondRepo"
        ]);
    }
}
