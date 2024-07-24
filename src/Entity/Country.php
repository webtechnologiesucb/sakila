<?php

namespace PHPMaker2024\Sakila\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\Sakila\AbstractEntity;
use PHPMaker2024\Sakila\AdvancedSecurity;
use PHPMaker2024\Sakila\UserProfile;
use function PHPMaker2024\Sakila\Config;
use function PHPMaker2024\Sakila\EntityManager;
use function PHPMaker2024\Sakila\RemoveXss;
use function PHPMaker2024\Sakila\HtmlDecode;
use function PHPMaker2024\Sakila\EncryptPassword;

/**
 * Entity class for "country" table
 */
#[Entity]
#[Table(name: "country")]
class Country extends AbstractEntity
{
    #[Id]
    #[Column(name: "country_id", type: "smallint", unique: true)]
    #[GeneratedValue]
    private int $countryId;

    #[Column(type: "string")]
    private string $country;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getCountryId(): int
    {
        return $this->countryId;
    }

    public function setCountryId(int $value): static
    {
        $this->countryId = $value;
        return $this;
    }

    public function getCountry(): string
    {
        return HtmlDecode($this->country);
    }

    public function setCountry(string $value): static
    {
        $this->country = RemoveXss($value);
        return $this;
    }

    public function getLastUpdate(): DateTime
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(DateTime $value): static
    {
        $this->lastUpdate = $value;
        return $this;
    }
}
