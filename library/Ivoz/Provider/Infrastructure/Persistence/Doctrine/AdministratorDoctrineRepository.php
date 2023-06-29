<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Provider\Domain\Model\Administrator\Administrator;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * AdministratorDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<Administrator>
 */
class AdministratorDoctrineRepository extends ServiceEntityRepository implements AdministratorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Administrator::class);
    }

    /**
     * @inheritdoc
     * @see AdministratorRepository::getInnerGlobalAdmin
     */
    public function getInnerGlobalAdmin()
    {
        $qb = $this->createQueryBuilder('self');

        $qb
            ->select('self')
            ->addCriteria(
                CriteriaHelper::fromArray([
                    ['id', 'eq', 0],
                    ['active', 'eq', 0],
                    ['brand', 'isNUll'],
                    ['company', 'isNUll']
                ])
            );

        $result = $qb->getQuery()->getResult();
        $privateAdmin = current($result);
        if (!$privateAdmin) {
            throw new \RuntimeException('Unable to find inner global admin');
        }

        return $privateAdmin;
    }

    public function findAdminByUsername(string $username): ?AdministratorInterface
    {
        /** @var AdministratorInterface | null $admin */
        $admin = $this->findOneBy([
            'username' => $username
        ]);

        return $admin;
    }

    /**
     * @param string $username
     * @return null| AdministratorInterface
     */
    public function findPlatformAdminByUsername(string $username)
    {
        /** @var AdministratorInterface | null $admin */
        $admin = $this->findOneBy([
            'username' => $username,
            'brand' => null,
            'company' => null
        ]);

        return $admin;
    }

    /**
     * @param string $username
     * @return null| AdministratorInterface
     */
    public function findBrandAdminByUsername(string $username)
    {
        $criteria = [
            ['username', 'eq', $username],
            ['brand', 'isNotNull'],
            ['company', 'isNull']
        ];

        return $this->findOneByCriteria(
            $criteria
        );
    }

    /**
     * @param string $username
     * @return null| AdministratorInterface
     */
    public function findClientAdminByUsername(string $username)
    {
        $criteria = [
            ['username', 'eq', $username],
            ['brand', 'isNotNull'],
            ['company', 'isNotNull']
        ];

        return $this->findOneByCriteria(
            $criteria
        );
    }

    /**
     * @return AdministratorInterface|null
     */
    private function findOneByCriteria(array $criteria)
    {
        $qb = $this->createQueryBuilder('self');

        $qb
            ->select('self')
            ->addCriteria(
                CriteriaHelper::fromArray($criteria)
            );
        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }
}
