<?php

namespace App\Entity;

use App\Entity\Abstract\Humanoide;
use App\Repository\MonsterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonsterRepository::class)
 */
class Monster
{
    

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $monster;

    

    public function getMonster(): ?string
    {
        return $this->monster;
    }

    public function setMonster(string $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    use Humanoide;
}
