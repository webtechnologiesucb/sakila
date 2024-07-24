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
 * Entity class for "language" table
 */
#[Entity]
#[Table(name: "language")]
class Language extends AbstractEntity
{
    #[Id]
    #[Column(name: "language_id", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $languageId;

    #[Column(type: "string")]
    private string $name;

    #[Column(name: "last_update", type: "datetime")]
    private DateTime $lastUpdate;

    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    public function setLanguageId(int $value): static
    {
        $this->languageId = $value;
        return $this;
    }

    public function getName(): string
    {
        return HtmlDecode($this->name);
    }

    public function setName(string $value): static
    {
        $this->name = RemoveXss($value);
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
