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
 * Entity class for "film" table
 */
#[Entity]
#[Table(name: "film")]
class Film extends AbstractEntity
{
    #[Id]
    #[Column(name: "film_id", type: "smallint", unique: true)]
    #[GeneratedValue]
    private int $filmId;

    #[Column(type: "string")]
    private string $title;

    #[Column(type: "text", nullable: true)]
    private ?string $description;

    #[Column(name: "release_year", type: "smallint", nullable: true)]
    private ?int $releaseYear;

    #[Column(name: "language_id", type: "integer")]
    private int $languageId;

    #[Column(name: "original_language_id", type: "integer", nullable: true)]
    private ?int $originalLanguageId;

    #[Column(name: "rental_duration", type: "integer")]
    private int $rentalDuration;

    #[Column(name: "rental_rate", type: "decimal")]
    private string $rentalRate;

    #[Column(type: "smallint", nullable: true)]
    private ?int $length;

    #[Column(name: "replacement_cost", type: "decimal")]
    private string $replacementCost;

    #[Column(type: "string", nullable: true)]
    private ?string $rating;

    #[Column(name: "special_features", type: "simple_array", nullable: true)]
    private ?array $specialFeatures;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function __construct()
    {
        $this->rentalDuration = 3;
        $this->rentalRate = "4.99";
        $this->replacementCost = "19.99";
        $this->rating = "G";
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

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(?int $value): static
    {
        $this->releaseYear = $value;
        return $this;
    }

    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    public function setLanguageId(int $value): static
    {
        $this->languageId = $value;
        return $this;
    }

    public function getOriginalLanguageId(): ?int
    {
        return $this->originalLanguageId;
    }

    public function setOriginalLanguageId(?int $value): static
    {
        $this->originalLanguageId = $value;
        return $this;
    }

    public function getRentalDuration(): int
    {
        return $this->rentalDuration;
    }

    public function setRentalDuration(int $value): static
    {
        $this->rentalDuration = $value;
        return $this;
    }

    public function getRentalRate(): string
    {
        return $this->rentalRate;
    }

    public function setRentalRate(string $value): static
    {
        $this->rentalRate = $value;
        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $value): static
    {
        $this->length = $value;
        return $this;
    }

    public function getReplacementCost(): string
    {
        return $this->replacementCost;
    }

    public function setReplacementCost(string $value): static
    {
        $this->replacementCost = $value;
        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $value): static
    {
        if (!in_array($value, ["G", "PG", "PG-13", "R", "NC-17"])) {
            throw new \InvalidArgumentException("Invalid 'rating' value");
        }
        $this->rating = $value;
        return $this;
    }

    public function getSpecialFeatures(): ?array
    {
        return $this->specialFeatures;
    }

    public function setSpecialFeatures(?array $value): static
    {
        if (count(array_filter($value, fn($v) => !in_array($v, ["Trailers", "Commentaries", "Deleted Scenes", "Behind the Scenes"]))) > 0) {
            throw new \InvalidArgumentException("Invalid 'special_features' value");
        }
        $this->specialFeatures = $value;
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
