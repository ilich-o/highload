<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws Exception
     */
    public function searchByFirstLastName(string $firstName, string $lastName, int $limit = 500, int $offset = 0): array
    {
        $sql = 'SELECT * FROM user WHERE first_name LIKE :firstName AND second_name LIKE :lastName ORDER BY id LIMIT :limit OFFSET :offset';

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue('limit', $limit, ParameterType::INTEGER);
        $stmt->bindValue('offset', $offset, ParameterType::INTEGER);
        $stmt->bindValue('firstName', "$firstName%");
        $stmt->bindValue('lastName', "$lastName%");

        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        return null;
    }
}
