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
 * Entity class for "inventory" table
 */
#[Entity]
#[Table(name: "inventory")]
class Inventory extends AbstractEntity
{
    #[Id]
    #[Column(name: "inventory_id", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $inventoryId;

    #[Column(name: "film_id", type: "smallint")]
    private int $filmId;

    #[Column(name: "store_id", type: "integer")]
    private int $storeId;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getInventoryId(): int
    {
        return $this->inventoryId;
    }

    public function setInventoryId(int $value): static
    {
        $this->inventoryId = $value;
        return $this;
    }

    public function getFilmId(): int
    {
        return $this->filmId;
    }

    public function setFilmId(int $value): static
    {
        $this->filmId = $value;
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
