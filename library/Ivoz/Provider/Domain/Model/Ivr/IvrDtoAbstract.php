<?php

namespace Ivoz\Provider\Domain\Model\Ivr;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\Company\CompanyDto;
use Ivoz\Provider\Domain\Model\Locution\LocutionDto;
use Ivoz\Provider\Domain\Model\Extension\ExtensionDto;
use Ivoz\Provider\Domain\Model\User\UserDto;
use Ivoz\Provider\Domain\Model\Country\CountryDto;
use Ivoz\Provider\Domain\Model\IvrEntry\IvrEntryDto;
use Ivoz\Provider\Domain\Model\IvrExcludedExtension\IvrExcludedExtensionDto;

/**
* IvrDtoAbstract
* @codeCoverageIgnore
*/
abstract class IvrDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var int|null
     */
    private $timeout = null;

    /**
     * @var int|null
     */
    private $maxDigits = null;

    /**
     * @var bool|null
     */
    private $allowExtensions = false;

    /**
     * @var string|null
     */
    private $noInputRouteType = null;

    /**
     * @var string|null
     */
    private $noInputNumberValue = null;

    /**
     * @var string|null
     */
    private $errorRouteType = null;

    /**
     * @var string|null
     */
    private $errorNumberValue = null;

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var CompanyDto | null
     */
    private $company = null;

    /**
     * @var LocutionDto | null
     */
    private $welcomeLocution = null;

    /**
     * @var LocutionDto | null
     */
    private $noInputLocution = null;

    /**
     * @var LocutionDto | null
     */
    private $errorLocution = null;

    /**
     * @var LocutionDto | null
     */
    private $successLocution = null;

    /**
     * @var ExtensionDto | null
     */
    private $noInputExtension = null;

    /**
     * @var ExtensionDto | null
     */
    private $errorExtension = null;

    /**
     * @var UserDto | null
     */
    private $noInputVoiceMailUser = null;

    /**
     * @var UserDto | null
     */
    private $errorVoiceMailUser = null;

    /**
     * @var CountryDto | null
     */
    private $noInputNumberCountry = null;

    /**
     * @var CountryDto | null
     */
    private $errorNumberCountry = null;

    /**
     * @var IvrEntryDto[] | null
     */
    private $entries = null;

    /**
     * @var IvrExcludedExtensionDto[] | null
     */
    private $excludedExtensions = null;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
    * @inheritdoc
    */
    public static function getPropertyMap(string $context = '', string $role = null): array
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'name' => 'name',
            'timeout' => 'timeout',
            'maxDigits' => 'maxDigits',
            'allowExtensions' => 'allowExtensions',
            'noInputRouteType' => 'noInputRouteType',
            'noInputNumberValue' => 'noInputNumberValue',
            'errorRouteType' => 'errorRouteType',
            'errorNumberValue' => 'errorNumberValue',
            'id' => 'id',
            'companyId' => 'company',
            'welcomeLocutionId' => 'welcomeLocution',
            'noInputLocutionId' => 'noInputLocution',
            'errorLocutionId' => 'errorLocution',
            'successLocutionId' => 'successLocution',
            'noInputExtensionId' => 'noInputExtension',
            'errorExtensionId' => 'errorExtension',
            'noInputVoiceMailUserId' => 'noInputVoiceMailUser',
            'errorVoiceMailUserId' => 'errorVoiceMailUser',
            'noInputNumberCountryId' => 'noInputNumberCountry',
            'errorNumberCountryId' => 'errorNumberCountry'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'name' => $this->getName(),
            'timeout' => $this->getTimeout(),
            'maxDigits' => $this->getMaxDigits(),
            'allowExtensions' => $this->getAllowExtensions(),
            'noInputRouteType' => $this->getNoInputRouteType(),
            'noInputNumberValue' => $this->getNoInputNumberValue(),
            'errorRouteType' => $this->getErrorRouteType(),
            'errorNumberValue' => $this->getErrorNumberValue(),
            'id' => $this->getId(),
            'company' => $this->getCompany(),
            'welcomeLocution' => $this->getWelcomeLocution(),
            'noInputLocution' => $this->getNoInputLocution(),
            'errorLocution' => $this->getErrorLocution(),
            'successLocution' => $this->getSuccessLocution(),
            'noInputExtension' => $this->getNoInputExtension(),
            'errorExtension' => $this->getErrorExtension(),
            'noInputVoiceMailUser' => $this->getNoInputVoiceMailUser(),
            'errorVoiceMailUser' => $this->getErrorVoiceMailUser(),
            'noInputNumberCountry' => $this->getNoInputNumberCountry(),
            'errorNumberCountry' => $this->getErrorNumberCountry(),
            'entries' => $this->getEntries(),
            'excludedExtensions' => $this->getExcludedExtensions()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setTimeout(int $timeout): static
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function setMaxDigits(int $maxDigits): static
    {
        $this->maxDigits = $maxDigits;

        return $this;
    }

    public function getMaxDigits(): ?int
    {
        return $this->maxDigits;
    }

    public function setAllowExtensions(bool $allowExtensions): static
    {
        $this->allowExtensions = $allowExtensions;

        return $this;
    }

    public function getAllowExtensions(): ?bool
    {
        return $this->allowExtensions;
    }

    public function setNoInputRouteType(?string $noInputRouteType): static
    {
        $this->noInputRouteType = $noInputRouteType;

        return $this;
    }

    public function getNoInputRouteType(): ?string
    {
        return $this->noInputRouteType;
    }

    public function setNoInputNumberValue(?string $noInputNumberValue): static
    {
        $this->noInputNumberValue = $noInputNumberValue;

        return $this;
    }

    public function getNoInputNumberValue(): ?string
    {
        return $this->noInputNumberValue;
    }

    public function setErrorRouteType(?string $errorRouteType): static
    {
        $this->errorRouteType = $errorRouteType;

        return $this;
    }

    public function getErrorRouteType(): ?string
    {
        return $this->errorRouteType;
    }

    public function setErrorNumberValue(?string $errorNumberValue): static
    {
        $this->errorNumberValue = $errorNumberValue;

        return $this;
    }

    public function getErrorNumberValue(): ?string
    {
        return $this->errorNumberValue;
    }

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCompany(?CompanyDto $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?CompanyDto
    {
        return $this->company;
    }

    public function setCompanyId($id): static
    {
        $value = !is_null($id)
            ? new CompanyDto($id)
            : null;

        return $this->setCompany($value);
    }

    public function getCompanyId()
    {
        if ($dto = $this->getCompany()) {
            return $dto->getId();
        }

        return null;
    }

    public function setWelcomeLocution(?LocutionDto $welcomeLocution): static
    {
        $this->welcomeLocution = $welcomeLocution;

        return $this;
    }

    public function getWelcomeLocution(): ?LocutionDto
    {
        return $this->welcomeLocution;
    }

    public function setWelcomeLocutionId($id): static
    {
        $value = !is_null($id)
            ? new LocutionDto($id)
            : null;

        return $this->setWelcomeLocution($value);
    }

    public function getWelcomeLocutionId()
    {
        if ($dto = $this->getWelcomeLocution()) {
            return $dto->getId();
        }

        return null;
    }

    public function setNoInputLocution(?LocutionDto $noInputLocution): static
    {
        $this->noInputLocution = $noInputLocution;

        return $this;
    }

    public function getNoInputLocution(): ?LocutionDto
    {
        return $this->noInputLocution;
    }

    public function setNoInputLocutionId($id): static
    {
        $value = !is_null($id)
            ? new LocutionDto($id)
            : null;

        return $this->setNoInputLocution($value);
    }

    public function getNoInputLocutionId()
    {
        if ($dto = $this->getNoInputLocution()) {
            return $dto->getId();
        }

        return null;
    }

    public function setErrorLocution(?LocutionDto $errorLocution): static
    {
        $this->errorLocution = $errorLocution;

        return $this;
    }

    public function getErrorLocution(): ?LocutionDto
    {
        return $this->errorLocution;
    }

    public function setErrorLocutionId($id): static
    {
        $value = !is_null($id)
            ? new LocutionDto($id)
            : null;

        return $this->setErrorLocution($value);
    }

    public function getErrorLocutionId()
    {
        if ($dto = $this->getErrorLocution()) {
            return $dto->getId();
        }

        return null;
    }

    public function setSuccessLocution(?LocutionDto $successLocution): static
    {
        $this->successLocution = $successLocution;

        return $this;
    }

    public function getSuccessLocution(): ?LocutionDto
    {
        return $this->successLocution;
    }

    public function setSuccessLocutionId($id): static
    {
        $value = !is_null($id)
            ? new LocutionDto($id)
            : null;

        return $this->setSuccessLocution($value);
    }

    public function getSuccessLocutionId()
    {
        if ($dto = $this->getSuccessLocution()) {
            return $dto->getId();
        }

        return null;
    }

    public function setNoInputExtension(?ExtensionDto $noInputExtension): static
    {
        $this->noInputExtension = $noInputExtension;

        return $this;
    }

    public function getNoInputExtension(): ?ExtensionDto
    {
        return $this->noInputExtension;
    }

    public function setNoInputExtensionId($id): static
    {
        $value = !is_null($id)
            ? new ExtensionDto($id)
            : null;

        return $this->setNoInputExtension($value);
    }

    public function getNoInputExtensionId()
    {
        if ($dto = $this->getNoInputExtension()) {
            return $dto->getId();
        }

        return null;
    }

    public function setErrorExtension(?ExtensionDto $errorExtension): static
    {
        $this->errorExtension = $errorExtension;

        return $this;
    }

    public function getErrorExtension(): ?ExtensionDto
    {
        return $this->errorExtension;
    }

    public function setErrorExtensionId($id): static
    {
        $value = !is_null($id)
            ? new ExtensionDto($id)
            : null;

        return $this->setErrorExtension($value);
    }

    public function getErrorExtensionId()
    {
        if ($dto = $this->getErrorExtension()) {
            return $dto->getId();
        }

        return null;
    }

    public function setNoInputVoiceMailUser(?UserDto $noInputVoiceMailUser): static
    {
        $this->noInputVoiceMailUser = $noInputVoiceMailUser;

        return $this;
    }

    public function getNoInputVoiceMailUser(): ?UserDto
    {
        return $this->noInputVoiceMailUser;
    }

    public function setNoInputVoiceMailUserId($id): static
    {
        $value = !is_null($id)
            ? new UserDto($id)
            : null;

        return $this->setNoInputVoiceMailUser($value);
    }

    public function getNoInputVoiceMailUserId()
    {
        if ($dto = $this->getNoInputVoiceMailUser()) {
            return $dto->getId();
        }

        return null;
    }

    public function setErrorVoiceMailUser(?UserDto $errorVoiceMailUser): static
    {
        $this->errorVoiceMailUser = $errorVoiceMailUser;

        return $this;
    }

    public function getErrorVoiceMailUser(): ?UserDto
    {
        return $this->errorVoiceMailUser;
    }

    public function setErrorVoiceMailUserId($id): static
    {
        $value = !is_null($id)
            ? new UserDto($id)
            : null;

        return $this->setErrorVoiceMailUser($value);
    }

    public function getErrorVoiceMailUserId()
    {
        if ($dto = $this->getErrorVoiceMailUser()) {
            return $dto->getId();
        }

        return null;
    }

    public function setNoInputNumberCountry(?CountryDto $noInputNumberCountry): static
    {
        $this->noInputNumberCountry = $noInputNumberCountry;

        return $this;
    }

    public function getNoInputNumberCountry(): ?CountryDto
    {
        return $this->noInputNumberCountry;
    }

    public function setNoInputNumberCountryId($id): static
    {
        $value = !is_null($id)
            ? new CountryDto($id)
            : null;

        return $this->setNoInputNumberCountry($value);
    }

    public function getNoInputNumberCountryId()
    {
        if ($dto = $this->getNoInputNumberCountry()) {
            return $dto->getId();
        }

        return null;
    }

    public function setErrorNumberCountry(?CountryDto $errorNumberCountry): static
    {
        $this->errorNumberCountry = $errorNumberCountry;

        return $this;
    }

    public function getErrorNumberCountry(): ?CountryDto
    {
        return $this->errorNumberCountry;
    }

    public function setErrorNumberCountryId($id): static
    {
        $value = !is_null($id)
            ? new CountryDto($id)
            : null;

        return $this->setErrorNumberCountry($value);
    }

    public function getErrorNumberCountryId()
    {
        if ($dto = $this->getErrorNumberCountry()) {
            return $dto->getId();
        }

        return null;
    }

    public function setEntries(?array $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getEntries(): ?array
    {
        return $this->entries;
    }

    public function setExcludedExtensions(?array $excludedExtensions): static
    {
        $this->excludedExtensions = $excludedExtensions;

        return $this;
    }

    public function getExcludedExtensions(): ?array
    {
        return $this->excludedExtensions;
    }
}
