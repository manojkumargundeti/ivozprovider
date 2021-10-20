<?php

declare(strict_types=1);

namespace Ivoz\Kam\Domain\Model\TrunksHtable;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;

/**
* TrunksHtableAbstract
* @codeCoverageIgnore
*/
abstract class TrunksHtableAbstract
{
    use ChangelogTrait;

    /**
     * column: key_name
     */
    protected $keyName = '';

    /**
     * column: key_type
     */
    protected $keyType = 0;

    /**
     * column: value_type
     */
    protected $valueType = 0;

    /**
     * column: key_value
     */
    protected $keyValue = '';

    protected $expires = 0;

    /**
     * Constructor
     */
    protected function __construct(
        string $keyName,
        int $keyType,
        int $valueType,
        string $keyValue,
        int $expires
    ) {
        $this->setKeyName($keyName);
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
        $this->setKeyValue($keyValue);
        $this->setExpires($expires);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "TrunksHtable",
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
    public static function createDto($id = null): TrunksHtableDto
    {
        return new TrunksHtableDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param TrunksHtableInterface|null $entity
     * @param int $depth
     * @return TrunksHtableDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, TrunksHtableInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var TrunksHtableDto $dto */
        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param TrunksHtableDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, TrunksHtableDto::class);

        $self = new static(
            $dto->getKeyName(),
            $dto->getKeyType(),
            $dto->getValueType(),
            $dto->getKeyValue(),
            $dto->getExpires()
        );

        ;

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param TrunksHtableDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, TrunksHtableDto::class);

        $this
            ->setKeyName($dto->getKeyName())
            ->setKeyType($dto->getKeyType())
            ->setValueType($dto->getValueType())
            ->setKeyValue($dto->getKeyValue())
            ->setExpires($dto->getExpires());

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     */
    public function toDto($depth = 0): TrunksHtableDto
    {
        return self::createDto()
            ->setKeyName(self::getKeyName())
            ->setKeyType(self::getKeyType())
            ->setValueType(self::getValueType())
            ->setKeyValue(self::getKeyValue())
            ->setExpires(self::getExpires());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'key_name' => self::getKeyName(),
            'key_type' => self::getKeyType(),
            'value_type' => self::getValueType(),
            'key_value' => self::getKeyValue(),
            'expires' => self::getExpires()
        ];
    }

    protected function setKeyName(string $keyName): static
    {
        Assertion::maxLength($keyName, 64, 'keyName value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->keyName = $keyName;

        return $this;
    }

    public function getKeyName(): string
    {
        return $this->keyName;
    }

    protected function setKeyType(int $keyType): static
    {
        $this->keyType = $keyType;

        return $this;
    }

    public function getKeyType(): int
    {
        return $this->keyType;
    }

    protected function setValueType(int $valueType): static
    {
        $this->valueType = $valueType;

        return $this;
    }

    public function getValueType(): int
    {
        return $this->valueType;
    }

    protected function setKeyValue(string $keyValue): static
    {
        Assertion::maxLength($keyValue, 128, 'keyValue value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->keyValue = $keyValue;

        return $this;
    }

    public function getKeyValue(): string
    {
        return $this->keyValue;
    }

    protected function setExpires(int $expires): static
    {
        $this->expires = $expires;

        return $this;
    }

    public function getExpires(): int
    {
        return $this->expires;
    }
}
