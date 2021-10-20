<?php

namespace Ivoz\Provider\Domain\Model\Timezone;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Provider\Domain\Model\Country\CountryInterface;

/**
* TimezoneInterface
*/
interface TimezoneInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet(): array;

    public function getTz(): string;

    public function getComment(): ?string;

    public function getLabel(): Label;

    public function getCountry(): ?CountryInterface;

    public function isInitialized(): bool;
}
