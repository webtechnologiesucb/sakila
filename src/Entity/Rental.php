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
 * Entity class for "rental" table
 */
#[Entity]
#[Table(name: "rental")]
class Rental extends AbstractEntity
{
    #[Id]
    #[Column(name: "rental_id", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $rentalId;

    #[Column(name: "rental_date", type: "datetime")]
    private DateTime $rentalDate;

    #[Column(name: "inventory_id", type: "integer")]
    private int $inventoryId;

    #[Column(name: "customer_id", type: "smallint")]
    private int $customerId;

    #[Column(name: "return_date", type: "datetime", nullable: true)]
    private ?DateTime $returnDate;

    #[Column(name: "staff_id", type: "integer")]
    private int $staffId;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getRentalId(): int
    {
        return $this->rentalId;
    }

    public function setRentalId(int $value): static
    {
        $this->rentalId = $value;
        return $this;
    }

    public function getRentalDate(): DateTime
    {
        return $this->rentalDate;
    }

    public function setRentalDate(DateTime $value): static
    {
        $this->rentalDate = $value;
        return $this;
    }

    public function getInventoryId(): int
    {
        return $this->inventoryId;
    }

    public function setInventoryId(int $value): static
    {
        $this->inventoryId = $value;
        return $this;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $value): static
    {
        $this->customerId = $value;
        return $this;
    }

    public function getReturnDate(): ?DateTime
    {
        return $this->returnDate;
    }

    public function setReturnDate(?DateTime $value): static
    {
        $this->returnDate = $value;
        return $this;
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
