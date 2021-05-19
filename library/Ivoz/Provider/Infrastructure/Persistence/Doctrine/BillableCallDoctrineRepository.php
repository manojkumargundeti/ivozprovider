<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Ivoz\Core\Infrastructure\Domain\Service\DoctrineQueryRunner;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Traits\GetGeneratorByConditionsTrait;
use Ivoz\Provider\Domain\Model\BillableCall\BillableCall;
use Ivoz\Provider\Domain\Model\BillableCall\BillableCallInterface;
use Ivoz\Provider\Domain\Model\BillableCall\BillableCallRepository;
use Ivoz\Provider\Domain\Model\Invoice\InvoiceInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * BillableCallDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BillableCallDoctrineRepository extends ServiceEntityRepository implements BillableCallRepository
{
    const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    use GetGeneratorByConditionsTrait;

    protected $queryRunner;

    public function __construct(
        RegistryInterface $registry,
        DoctrineQueryRunner $queryRunner
    ) {
        parent::__construct($registry, BillableCall::class);
        $this->queryRunner = $queryRunner;
    }

    /**
     * @param string $callid
     * @param int $brandId
     * @return BillableCallInterface[]
     */
    public function findOutboundByCallid(string $callid, int $brandId = null)
    {
        $criteria = [
            'callid' => $callid,
            'direction' => BillableCallInterface::DIRECTION_OUTBOUND
        ];

        if ($brandId) {
            $criteria['brand'] = $brandId;
        }

        /** @var BillableCallInterface[] $response */
        $response = $this->findBy(
            $criteria
        );

        return $response;
    }

    /**
     * @param int $id
     * @return BillableCallInterface
     */
    public function findOneByTrunksCdrId($id)
    {
        /** @var BillableCallInterface $response */
        $response = $this->findOneBy([
            'trunksCdr' => $id
        ]);

        return $response;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::areRetarificable
     */
    public function areRetarificable(array $pks)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['id', 'in', $pks],
            'or' => [
                ['invoice', 'isNotNull']
            ]
        ];

        $qb
            ->select('count(self)')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $elementNumber = (int) $qb->getQuery()->getSingleScalarResult();
        return $elementNumber === 0;
    }

    /**
     * Return non externally rated calls without cgrid
     * @inheritdoc
     * @see BillableCallRepository::findUnratedInGroup
     */
    public function findUnratedInGroup(array $pks)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['self.id', 'in', $pks],
            ['self.invoice', 'isNull'],
            ['trunksCdr.cgrid', 'isNull'],
            ['self.direction', 'eq', BillableCallInterface::DIRECTION_OUTBOUND],
            'or' => [
                ['carrier.externallyRated', 'eq', 0],
                ['self.carrier', 'isNUll']
            ]
        ];

        $qb
            ->select('self, trunksCdr')
            ->innerJoin('self.trunksCdr', 'trunksCdr')
            ->leftJoin('self.carrier', 'carrier')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );
        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::findRerateableCgridsInGroup
     */
    public function findRerateableCgridsInGroup(array $ids)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['id', 'in', $ids],
            ['trunksCdr.cgrid', 'isNotNull'],
            ['self.direction', 'eq', BillableCallInterface::DIRECTION_OUTBOUND],
            'or' => [
                ['carrier.externallyRated', 'eq', 0],
                ['self.carrier', 'isNull']
            ]
        ];

        $qb
            ->select('self, trunksCdr')
            ->innerJoin('self.trunksCdr', 'trunksCdr')
            ->leftJoin('self.carrier', 'carrier')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $query = $qb->getQuery();

        /** @var BillableCallInterface[] $billableCalls */
        $billableCalls = $query->getResult();

        $cgrids = [];
        foreach ($billableCalls as $billableCall) {
            $cgrids[] = $billableCall->getTrunksCdr()->getCgrid();
        }

        return $cgrids;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::idsToTrunkCdrId
     */
    public function idsToTrunkCdrId(array $ids)
    {
        $qb = $this->createQueryBuilder('self');

        $conditions = [
            ['id', 'in', $ids]
        ];

        $qb
            ->select('IDENTITY(self.trunksCdr) as trunksCdr')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        $trunkCdrIds = array_map(
            function ($item) {
                return $item['trunksCdr'];
            },
            $result
        );

        if (count($ids) !== count($trunkCdrIds)) {
            throw new \RuntimeException('Some id were not found');
        }

        return $trunkCdrIds;
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::resetPricingData
     */
    public function resetPricingData(array $ids)
    {
        $qb = $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.price', ':nullValue')
            ->set('self.cost', ':nullValue')
            ->set('self.destination', ':nullValue')
            ->set('self.destinationName', ':nullValue')
            ->set('self.ratingPlanGroup', ':nullValue')
            ->set('self.ratingPlanName', ':nullValue')
            ->setParameter(':nullValue', null)
            ->where('self.id in (:ids)')
            ->setParameter(':ids', $ids);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::resetInvoiceId
     */
    public function resetInvoiceId(int $invoiceId)
    {
        $qb = $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.invoice', ':nullValue')
            ->setParameter(':nullValue', null)
            ->where('self.invoice = :invoiceId')
            ->setParameter(':invoiceId', $invoiceId);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::setInvoiceId
     */
    public function setInvoiceId(InvoiceInterface $invoice)
    {
        $conditions = $this->getConditionsByInvoice($invoice);

        // In order to reduce table lock times search target ids first
        $finder = $this
            ->createQueryBuilder('self')
            ->select('self.id')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            )
            ->getQuery();

        $targetIds = array_map(
            function (array $row) {
                return $row['id'];
            },
            $finder->execute()
        );

        if (empty($targetIds)) {
            return;
        }

        $qb = $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.invoice', ':invoiceId')
            ->setParameter(':invoiceId', $invoice->getId())
            ->addCriteria(
                CriteriaHelper::fromArray([
                    ['id', 'in', $targetIds],
                ])
            );

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    public function getGeneratorByInvoice(InvoiceInterface $invoice)
    {
        $conditions = $this->getConditionsByInvoice($invoice);

        return $this
            ->getGeneratorByConditions(
                $conditions,
                5000,
                ['self.startTime', 'ASC']
            );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::getUnratedCallIdsByInvoice
     */
    public function getUnratedCallIdsByInvoice(InvoiceInterface $invoice): array
    {
        $conditions = $this->getConditionsByInvoice(
            $invoice
        );

        $conditions['or'] = [
            ['price', 'isNull'],
            ['price', 'lt', 0],
        ];

        $qb = $this
            ->createQueryBuilder('self')
            ->select('self.id')
            ->addCriteria(
                CriteriaHelper::fromArray($conditions)
            );

        $result = $qb->getQuery()->getResult();

        return array_map(
            function ($row) {
                return $row['id'];
            },
            $result
        );
    }

    /**
     * @inheritdoc
     * @see BillableCallRepository::countUnratedCallsByInvoice
     */
    public function countUnratedCallsByInvoice(InvoiceInterface $invoice): int
    {
        $results = $this->getUnratedCallIdsByInvoice(
            $invoice
        );

        return count($results);
    }

    /**
     * @param InvoiceInterface $invoice
     * @return array
     */
    private function getConditionsByInvoice(InvoiceInterface $invoice): array
    {
        $utcTz = new \DateTimeZone('UTC');

        $brand = $invoice->getBrand();
        $company = $invoice->getCompany();

        $inDate = $invoice->getInDate();
        $utcInDate = $inDate->setTimezone($utcTz);

        $outDate = $invoice->getOutDate();
        $utcOutDate = $outDate->setTimezone($utcTz);

        return [
            ['brand', 'eq', $brand->getId()],
            ['company', 'eq', $company->getId()],
            ['startTime', 'gte', $utcInDate->format(self::MYSQL_DATETIME_FORMAT)],
            ['startTime', 'lte', $utcOutDate->format(self::MYSQL_DATETIME_FORMAT)],
            ['direction', 'eq', BillableCallInterface::DIRECTION_OUTBOUND],
        ];
    }

    /**
     * @param int $fromId
     * @return \DateTime
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMinStartTime(int $fromId = 0): \DateTime
    {
        $query =
            'SELECT MIN(B.startTime) FROM '
            . BillableCall::Class
            . ' B WHERE B.id > %d';

        $minStartTime = sprintf(
            $query,
            $fromId
        );

        $response = (new Query($this->_em))
            ->setDQL($minStartTime)
            ->getSingleScalarResult();

        return new \DateTime(
            $response,
            new \DateTimeZone('UTC')
        );
    }

    /**
     * @param int $fromId
     * @param \DateTime $date
     * @return int
     */
    public function getMaxIdUntilDate(int $fromId, \DateTime $date): int
    {
        $query =
            'SELECT MAX(B.id) FROM '
            . BillableCall::Class
            . ' B WHERE B.startTime <= \'%s\''
            . ' AND B.id > %d';

        $maxId = sprintf(
            $query,
            $date->format(self::MYSQL_DATETIME_FORMAT),
            $fromId
        );

        try {
            $response = (new Query($this->_em))
                ->setDQL($maxId)
                ->getSingleScalarResult();
        } catch (\Exception $e) {
            return $fromId;
        }

        if (is_null($response)) {
            return $fromId;
        }

        return (int) $response;
    }

    /**
     * @return int[]
     */
    public function getIdsInRange(int $fromId, int $untilId, int $limit): array
    {
        $query = sprintf(
            'SELECT B.id FROM '
            . BillableCall::Class
            . ' B WHERE B.id > %d'
            . ' AND B.id <= %d'
            . ' ORDER BY B.id ASC',
            $fromId,
            $untilId
        );

        $ids = (new Query($this->_em))
            ->setMaxResults($limit)
            ->setDQL($query)
            ->getResult();

        return array_column(
            $ids,
            'id'
        );
    }
}
