<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SearchController extends AbstractController
{
    public function __construct(private readonly UserRepository $userRepository)
    {

    }

    /**
     * @throws Exception
     */
    #[Route('/user/search', name: 'app_user_search')]
    public function __invoke(Request $request): JsonResponse
    {
        $users = $this->userRepository->searchByFirstLastName($request->query->get('first_name'), $request->query->get('last_name'));

        return $this->json($users);
    }
}
