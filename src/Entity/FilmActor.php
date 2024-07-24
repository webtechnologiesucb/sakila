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
 * Entity class for "film_actor" table
 */
#[Entity]
#[Table(name: "film_actor")]
class FilmActor extends AbstractEntity
{
    #[Id]
    #[Column(name: "actor_id", type: "smallint")]
    private int $actorId;

    #[Id]
    #[Column(name: "film_id", type: "smallint")]
    private int $filmId;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function __construct(int $actorId, int $filmId)
    {
        $this->actorId = $actorId;
        $this->filmId = $filmId;
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

    public function getFilmId(): int
    {
        return $this->filmId;
    }

    public function setFilmId(int $value): static
    {
        $this->filmId = $value;
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
