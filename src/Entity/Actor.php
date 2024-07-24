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
 * Entity class for "actor" table
 */
#[Entity]
#[Table(name: "actor")]
class Actor extends AbstractEntity
{
    #[Id]
    #[Column(name: "actor_id", type: "smallint", unique: true)]
    #[GeneratedValue]
    private int $actorId;

    #[Column(name: "first_name", type: "string")]
    private string $firstName;

    #[Column(name: "last_name", type: "string")]
    private string $lastName;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

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
