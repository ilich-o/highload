<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(private readonly UserRepository $userRepository)
    {

    }
    #[Route('/user/{userId}', name: 'app_user')]
    public function index(int $userId): JsonResponse
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->json($user);
    }
}
