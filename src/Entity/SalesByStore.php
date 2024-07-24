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
 * Entity class for "sales_by_store" table
 */
#[Entity]
#[Table(name: "sales_by_store")]
class SalesByStore extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $store;

    #[Column(type: "string", nullable: true)]
    private ?string $manager;

    #[Column(name: "total_sales", type: "decimal", nullable: true)]
    private ?string $totalSales;

    public function getStore(): ?string
    {
        return HtmlDecode($this->store);
    }

    public function setStore(?string $value): static
    {
        $this->store = RemoveXss($value);
        return $this;
    }

    public function getManager(): ?string
    {
        return HtmlDecode($this->manager);
    }

    public function setManager(?string $value): static
    {
        $this->manager = RemoveXss($value);
        return $this;
    }

    public function getTotalSales(): ?string
    {
        return $this->totalSales;
    }

    public function setTotalSales(?string $value): static
    {
        $this->totalSales = $value;
        return $this;
    }
}
