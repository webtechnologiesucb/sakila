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
 * Entity class for "film_category" table
 */
#[Entity]
#[Table(name: "film_category")]
class FilmCategory extends AbstractEntity
{
    #[Id]
    #[Column(name: "film_id", type: "smallint")]
    private int $filmId;

    #[Id]
    #[Column(name: "category_id", type: "integer")]
    private int $categoryId;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function __construct(int $filmId, int $categoryId)
    {
        $this->filmId = $filmId;
        $this->categoryId = $categoryId;
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

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $value): static
    {
        $this->categoryId = $value;
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
