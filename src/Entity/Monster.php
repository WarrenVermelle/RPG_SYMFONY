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

    /**
     * @ORM\Column(type="integer")
     */
    private $hpMax;

    

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

    public function getHpMax(): ?int
    {
        return $this->hpMax;
    }

    public function setHpMax(int $hpMax): self
    {
        $this->hpMax = $hpMax;

        return $this;
    }
}
