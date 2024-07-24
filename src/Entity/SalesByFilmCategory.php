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
 * Entity class for "sales_by_film_category" table
 */
#[Entity]
#[Table(name: "sales_by_film_category")]
class SalesByFilmCategory extends AbstractEntity
{
    #[Column(type: "string")]
    private string $category;

    #[Column(name: "total_sales", type: "decimal", nullable: true)]
    private ?string $totalSales;

    public function getCategory(): string
    {
        return HtmlDecode($this->category);
    }

    public function setCategory(string $value): static
    {
        $this->category = RemoveXss($value);
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
