<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Provider\Domain\Model\Domain\DomainInterface;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccount;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountInterface;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountRepository;
use Ivoz\Provider\Infrastructure\Persistence\Doctrine\Traits\CountByCriteriaTrait;
use Doctrine\Persistence\ManagerRegistry;

/**
 * RetailAccountRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RetailAccountDoctrineRepository extends ServiceEntityRepository implements RetailAccountRepository
{
    use CountByCriteriaTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetailAccount::class);
    }

    /**
     * @inheritdoc
     */
    public function findOneByNameAndDomain(string $name, DomainInterface $domain)
    {
        /** @var RetailAccountInterface $response */
        $response = $this->findOneBy([
            "name" => $name,
            "domain" => $domain
        ]);

        return $response;
    }

    /**
     * @param int $companyId
     * @return string[]
     */
    public function findNamesByCompanyId(int $companyId): array
    {
        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('self.name')
            ->where(
                $expression->eq('self.company', $companyId)
            );

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        return array_column(
            $result,
            'name'
        );
    }

    public function countRegistrableDevicesByCompanies(array $companyIds): int
    {
        $criteria = CriteriaHelper::fromArray([
            ['company', 'in', $companyIds],
            ['directConnectivity', 'eq', RetailAccountInterface::DIRECTCONNECTIVITY_NO],
        ]);

        return $this->countByCriteria($criteria);
    }
}
