<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\InvoiceNumberSequence;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Brand\Brand;

/**
* InvoiceNumberSequenceAbstract
* @codeCoverageIgnore
*/
abstract class InvoiceNumberSequenceAbstract
{
    use ChangelogTrait;

    protected $name;

    protected $prefix = '';

    protected $sequenceLength;

    protected $increment;

    protected $latestValue = '';

    protected $iteration = 0;

    protected $version = 1;

    /**
     * @var BrandInterface
     */
    protected $brand;

    /**
     * Constructor
     */
    protected function __construct(
        string $name,
        string $prefix,
        int $sequenceLength,
        int $increment,
        int $iteration,
        int $version
    ) {
        $this->setName($name);
        $this->setPrefix($prefix);
        $this->setSequenceLength($sequenceLength);
        $this->setIncrement($increment);
        $this->setIteration($iteration);
        $this->setVersion($version);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "InvoiceNumberSequence",
            $this->getId()
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @param mixed $id
     */
    public static function createDto($id = null): InvoiceNumberSequenceDto
    {
        return new InvoiceNumberSequenceDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param InvoiceNumberSequenceInterface|null $entity
     * @param int $depth
     * @return InvoiceNumberSequenceDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, InvoiceNumberSequenceInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var InvoiceNumberSequenceDto $dto */
        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param InvoiceNumberSequenceDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, InvoiceNumberSequenceDto::class);

        $self = new static(
            $dto->getName(),
            $dto->getPrefix(),
            $dto->getSequenceLength(),
            $dto->getIncrement(),
            $dto->getIteration(),
            $dto->getVersion()
        );

        $self
            ->setLatestValue($dto->getLatestValue())
            ->setBrand($fkTransformer->transform($dto->getBrand()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param InvoiceNumberSequenceDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, InvoiceNumberSequenceDto::class);

        $this
            ->setName($dto->getName())
            ->setPrefix($dto->getPrefix())
            ->setSequenceLength($dto->getSequenceLength())
            ->setIncrement($dto->getIncrement())
            ->setLatestValue($dto->getLatestValue())
            ->setIteration($dto->getIteration())
            ->setVersion($dto->getVersion())
            ->setBrand($fkTransformer->transform($dto->getBrand()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     */
    public function toDto($depth = 0): InvoiceNumberSequenceDto
    {
        return self::createDto()
            ->setName(self::getName())
            ->setPrefix(self::getPrefix())
            ->setSequenceLength(self::getSequenceLength())
            ->setIncrement(self::getIncrement())
            ->setLatestValue(self::getLatestValue())
            ->setIteration(self::getIteration())
            ->setVersion(self::getVersion())
            ->setBrand(Brand::entityToDto(self::getBrand(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'name' => self::getName(),
            'prefix' => self::getPrefix(),
            'sequenceLength' => self::getSequenceLength(),
            'increment' => self::getIncrement(),
            'latestValue' => self::getLatestValue(),
            'iteration' => self::getIteration(),
            'version' => self::getVersion(),
            'brandId' => self::getBrand()->getId()
        ];
    }

    protected function setName(string $name): static
    {
        Assertion::maxLength($name, 40, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function setPrefix(string $prefix): static
    {
        Assertion::maxLength($prefix, 20, 'prefix value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    protected function setSequenceLength(int $sequenceLength): static
    {
        Assertion::greaterOrEqualThan($sequenceLength, 0, 'sequenceLength provided "%s" is not greater or equal than "%s".');

        $this->sequenceLength = $sequenceLength;

        return $this;
    }

    public function getSequenceLength(): int
    {
        return $this->sequenceLength;
    }

    protected function setIncrement(int $increment): static
    {
        Assertion::greaterOrEqualThan($increment, 0, 'increment provided "%s" is not greater or equal than "%s".');

        $this->increment = $increment;

        return $this;
    }

    public function getIncrement(): int
    {
        return $this->increment;
    }

    protected function setLatestValue(?string $latestValue = null): static
    {
        $this->latestValue = $latestValue;

        return $this;
    }

    public function getLatestValue(): ?string
    {
        return $this->latestValue;
    }

    protected function setIteration(int $iteration): static
    {
        Assertion::greaterOrEqualThan($iteration, 0, 'iteration provided "%s" is not greater or equal than "%s".');

        $this->iteration = $iteration;

        return $this;
    }

    public function getIteration(): int
    {
        return $this->iteration;
    }

    protected function setVersion(int $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    protected function setBrand(BrandInterface $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }
}
