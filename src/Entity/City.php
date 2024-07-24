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
 * Entity class for "city" table
 */
#[Entity]
#[Table(name: "city")]
class City extends AbstractEntity
{
    #[Id]
    #[Column(name: "city_id", type: "smallint", unique: true)]
    #[GeneratedValue]
    private int $cityId;

    #[Column(type: "string")]
    private string $city;

    #[Column(name: "country_id", type: "smallint")]
    private int $countryId;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function setCityId(int $value): static
    {
        $this->cityId = $value;
        return $this;
    }

    public function getCity(): string
    {
        return HtmlDecode($this->city);
    }

    public function setCity(string $value): static
    {
        $this->city = RemoveXss($value);
        return $this;
    }

    public function getCountryId(): int
    {
        return $this->countryId;
    }

    public function setCountryId(int $value): static
    {
        $this->countryId = $value;
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
