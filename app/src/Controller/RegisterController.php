<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            throw new BadRequestHttpException('Wrong JSON request body');
        }

        $user = (new User())
            ->setFirstName($data['firstName'])
            ->setSecondName($data['secondName'])
            ->setBirthdate(new DateTime($data['birthDate']))
            ->setSex($data['sex'])
            ->setInterests($data['interests'])
            ->setCity($data['city'])
            ->setLogin($data['login'])
        ;
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'userId' => $user->getId(),
        ]);
    }
}
