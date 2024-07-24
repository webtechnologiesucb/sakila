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
 * Entity class for "actor_info" table
 */
#[Entity]
#[Table(name: "actor_info")]
class ActorInfo extends AbstractEntity
{
    #[Column(name: "actor_id", type: "smallint")]
    private int $actorId;

    #[Column(name: "first_name", type: "string")]
    private string $firstName;

    #[Column(name: "last_name", type: "string")]
    private string $lastName;

    #[Column(name: "film_info", type: "text", nullable: true)]
    private ?string $filmInfo;

    public function __construct()
    {
        $this->actorId = 0;
    }

    public function getActorId(): int
    {
        return $this->actorId;
    }

    public function setActorId(int $value): static
    {
        $this->actorId = $value;
        return $this;
    }

    public function getFirstName(): string
    {
        return HtmlDecode($this->firstName);
    }

    public function setFirstName(string $value): static
    {
        $this->firstName = RemoveXss($value);
        return $this;
    }

    public function getLastName(): string
    {
        return HtmlDecode($this->lastName);
    }

    public function setLastName(string $value): static
    {
        $this->lastName = RemoveXss($value);
        return $this;
    }

    public function getFilmInfo(): ?string
    {
        return HtmlDecode($this->filmInfo);
    }

    public function setFilmInfo(?string $value): static
    {
        $this->filmInfo = RemoveXss($value);
        return $this;
    }
}
