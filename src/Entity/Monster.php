<?php

namespace App\Entity;

use App\Entity\Abstract\Humanoide;
use App\Repository\MonsterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Loot::class, mappedBy="monster")
     */
    private $loots;

    public function __construct()
    {
        $this->loots = new ArrayCollection();
    }

    

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

    /**
     * @return Collection|Loot[]
     */
    public function getLoots(): Collection
    {
        return $this->loots;
    }

    public function addLoot(Loot $loot): self
    {
        if (!$this->loots->contains($loot)) {
            $this->loots[] = $loot;
            $loot->setMonster($this);
        }

        return $this;
    }

    public function removeLoot(Loot $loot): self
    {
        if ($this->loots->removeElement($loot)) {
            // set the owning side to null (unless already changed)
            if ($loot->getMonster() === $this) {
                $loot->setMonster(null);
            }
        }

        return $this;
    }
}
