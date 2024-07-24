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
 * Entity class for "film_text" table
 */
#[Entity]
#[Table(name: "film_text")]
class FilmText extends AbstractEntity
{
    #[Id]
    #[Column(name: "film_id", type: "smallint", unique: true)]
    private int $filmId;

    #[Column(type: "string")]
    private string $title;

    #[Column(type: "text", nullable: true)]
    private ?string $description;

    public function getFilmId(): int
    {
        return $this->filmId;
    }

    public function setFilmId(int $value): static
    {
        $this->filmId = $value;
        return $this;
    }

    public function getTitle(): string
    {
        return HtmlDecode($this->title);
    }

    public function setTitle(string $value): static
    {
        $this->title = RemoveXss($value);
        return $this;
    }

    public function getDescription(): ?string
    {
        return HtmlDecode($this->description);
    }

    public function setDescription(?string $value): static
    {
        $this->description = RemoveXss($value);
        return $this;
    }
}
