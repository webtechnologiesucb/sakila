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
 * Entity class for "staff" table
 */
#[Entity]
#[Table(name: "staff")]
class Staff extends AbstractEntity
{
    #[Id]
    #[Column(name: "staff_id", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $staffId;

    #[Column(name: "first_name", type: "string")]
    private string $firstName;

    #[Column(name: "last_name", type: "string")]
    private string $lastName;

    #[Column(name: "address_id", type: "smallint")]
    private int $addressId;

    #[Column(type: "blob", nullable: true)]
    private mixed $picture;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(name: "store_id", type: "integer")]
    private int $storeId;

    #[Column(type: "boolean")]
    private bool $active;

    #[Column(type: "string")]
    private string $username;

    #[Column(type: "string", nullable: true)]
    private ?string $password;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function __construct()
    {
        $this->active = true;
    }

    public function getStaffId(): int
    {
        return $this->staffId;
    }

    public function setStaffId(int $value): static
    {
        $this->staffId = $value;
        return $this;
    }

    public function getFirstName(): string
    {
        return HtmlDecode($this->firstName);
    }

    public function setFirstName(string $value): static
    {
        $this->firstName = RemoveXss($value);
        return $this;
    }

    public function getLastName(): string
    {
        return HtmlDecode($this->lastName);
    }

    public function setLastName(string $value): static
    {
        $this->lastName = RemoveXss($value);
        return $this;
    }

    public function getAddressId(): int
    {
        return $this->addressId;
    }

    public function setAddressId(int $value): static
    {
        $this->addressId = $value;
        return $this;
    }

    public function getPicture(): mixed
    {
        return $this->picture;
    }

    public function setPicture(mixed $value): static
    {
        $this->picture = $value;
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getStoreId(): int
    {
        return $this->storeId;
    }

    public function setStoreId(int $value): static
    {
        $this->storeId = $value;
        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $value): static
    {
        $this->active = $value;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $value): static
    {
        $this->username = $value;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $value): static
    {
        $this->password = EncryptPassword(Config("CASE_SENSITIVE_PASSWORD") ? $value : strtolower($value));
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

    // Get login arguments
    public function getLoginArguments(): array
    {
        return [
            "userName" => $this->get('username'),
            "userId" => null,
            "parentUserId" => null,
            "userLevel" => AdvancedSecurity::ANONYMOUS_USER_LEVEL_ID,
            "userPrimaryKey" => $this->get('staff_id'),
        ];
    }
}
