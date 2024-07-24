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
 * Entity class for "payment" table
 */
#[Entity]
#[Table(name: "payment")]
class Payment extends AbstractEntity
{
    #[Id]
    #[Column(name: "payment_id", type: "smallint", unique: true)]
    #[GeneratedValue]
    private int $paymentId;

    #[Column(name: "customer_id", type: "smallint")]
    private int $customerId;

    #[Column(name: "staff_id", type: "integer")]
    private int $staffId;

    #[Column(name: "rental_id", type: "integer", nullable: true)]
    private ?int $rentalId;

    #[Column(type: "decimal")]
    private string $amount;

    #[Column(name: "payment_date", type: "datetime")]
    private DateTime $paymentDate;

    #[Column(name: "last_update", type: "datetime", nullable: true)]
    private ?DateTime $lastUpdate;

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function setPaymentId(int $value): static
    {
        $this->paymentId = $value;
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

    public function getStaffId(): int
    {
        return $this->staffId;
    }

    public function setStaffId(int $value): static
    {
        $this->staffId = $value;
        return $this;
    }

    public function getRentalId(): ?int
    {
        return $this->rentalId;
    }

    public function setRentalId(?int $value): static
    {
        $this->rentalId = $value;
        return $this;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $value): static
    {
        $this->amount = $value;
        return $this;
    }

    public function getPaymentDate(): DateTime
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(DateTime $value): static
    {
        $this->paymentDate = $value;
        return $this;
    }

    public function getLastUpdate(): ?DateTime
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(?DateTime $value): static
    {
        $this->lastUpdate = $value;
        return $this;
    }
}
