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
 * Entity class for "staff_list" table
 */
#[Entity]
#[Table(name: "staff_list")]
class StaffList extends AbstractEntity
{
    #[Id]
    #[Column(name: "ID", type: "integer")]
    #[GeneratedValue]
    private int $id;

    #[Column(type: "string", nullable: true)]
    private ?string $name;

    #[Column(type: "string")]
    private string $address;

    #[Column(name: "`zip code`", options: ["name" => "zip code"], type: "string", nullable: true)]
    private ?string $zipcode;

    #[Column(type: "string")]
    private string $phone;

    #[Column(type: "string")]
    private string $city;

    #[Column(type: "string")]
    private string $country;

    #[Column(name: "SID", type: "integer")]
    private int $sid;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getName(): ?string
    {
        return HtmlDecode($this->name);
    }

    public function setName(?string $value): static
    {
        $this->name = RemoveXss($value);
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

    public function getZipcode(): ?string
    {
        return HtmlDecode($this->zipcode);
    }

    public function setZipcode(?string $value): static
    {
        $this->zipcode = RemoveXss($value);
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

    public function getCity(): string
    {
        return HtmlDecode($this->city);
    }

    public function setCity(string $value): static
    {
        $this->city = RemoveXss($value);
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

    public function getSid(): int
    {
        return $this->sid;
    }

    public function setSid(int $value): static
    {
        $this->sid = $value;
        return $this;
    }
}
