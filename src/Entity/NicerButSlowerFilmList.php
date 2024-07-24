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
 * Entity class for "nicer_but_slower_film_list" table
 */
#[Entity]
#[Table(name: "nicer_but_slower_film_list")]
class NicerButSlowerFilmList extends AbstractEntity
{
    #[Column(name: "FID", type: "smallint")]
    private int $fid;

    #[Column(type: "string")]
    private string $title;

    #[Column(type: "text", nullable: true)]
    private ?string $description;

    #[Column(type: "string", nullable: true)]
    private ?string $category;

    #[Column(type: "decimal")]
    private string $price;

    #[Column(type: "smallint", nullable: true)]
    private ?int $length;

    #[Column(type: "string", nullable: true)]
    private ?string $rating;

    #[Column(type: "text", nullable: true)]
    private ?string $actors;

    public function __construct()
    {
        $this->fid = 0;
        $this->price = "4.99";
        $this->rating = "G";
    }

    public function getFid(): int
    {
        return $this->fid;
    }

    public function setFid(int $value): static
    {
        $this->fid = $value;
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

    public function getCategory(): ?string
    {
        return HtmlDecode($this->category);
    }

    public function setCategory(?string $value): static
    {
        $this->category = RemoveXss($value);
        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $value): static
    {
        $this->price = $value;
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

    public function getActors(): ?string
    {
        return HtmlDecode($this->actors);
    }

    public function setActors(?string $value): static
    {
        $this->actors = RemoveXss($value);
        return $this;
    }
}
