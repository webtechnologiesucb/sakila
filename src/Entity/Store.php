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
 * Entity class for "store" table
 */
#[Entity]
#[Table(name: "store")]
class Store extends AbstractEntity
{
    #[Id]
    #[Column(name: "store_id", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $storeId;

    #[Column(name: "manager_staff_id", type: "integer", unique: true)]
    private int $managerStaffId;

    #[Column(name: "address_id", type: "smallint")]
    private int $addressId;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getStoreId(): int
    {
        return $this->storeId;
    }

    public function setStoreId(int $value): static
    {
        $this->storeId = $value;
        return $this;
    }

    public function getManagerStaffId(): int
    {
        return $this->managerStaffId;
    }

    public function setManagerStaffId(int $value): static
    {
        $this->managerStaffId = $value;
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
