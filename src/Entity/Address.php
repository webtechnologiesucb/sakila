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
 * Entity class for "address" table
 */
#[Entity]
#[Table(name: "address")]
class Address extends AbstractEntity
{
    #[Id]
    #[Column(name: "address_id", type: "smallint", unique: true)]
    #[GeneratedValue]
    private int $addressId;

    #[Column(type: "string")]
    private string $address;

    #[Column(type: "string", nullable: true)]
    private ?string $address2;

    #[Column(type: "string")]
    private string $district;

    #[Column(name: "city_id", type: "smallint")]
    private int $cityId;

    #[Column(name: "postal_code", type: "string", nullable: true)]
    private ?string $postalCode;

    #[Column(type: "string")]
    private string $phone;

    #[Column(type: "geometry")]
    private string $location;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getAddressId(): int
    {
        return $this->addressId;
    }

    public function setAddressId(int $value): static
    {
        $this->addressId = $value;
        return $this;
    }

    public function getAddress(): string
    {
        return HtmlDecode($this->address);
    }

    public function setAddress(string $value): static
    {
        $this->address = RemoveXss($value);
        return $this;
    }

    public function getAddress2(): ?string
    {
        return HtmlDecode($this->address2);
    }

    public function setAddress2(?string $value): static
    {
        $this->address2 = RemoveXss($value);
        return $this;
    }

    public function getDistrict(): string
    {
        return HtmlDecode($this->district);
    }

    public function setDistrict(string $value): static
    {
        $this->district = RemoveXss($value);
        return $this;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function setCityId(int $value): static
    {
        $this->cityId = $value;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return HtmlDecode($this->postalCode);
    }

    public function setPostalCode(?string $value): static
    {
        $this->postalCode = RemoveXss($value);
        return $this;
    }

    public function getPhone(): string
    {
        return HtmlDecode($this->phone);
    }

    public function setPhone(string $value): static
    {
        $this->phone = RemoveXss($value);
        return $this;
    }

    public function getLocation(): string
    {
        return HtmlDecode($this->location);
    }

    public function setLocation(string $value): static
    {
        $this->location = RemoveXss($value);
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
