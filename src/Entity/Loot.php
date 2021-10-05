<?php

namespace App\Entity;

use App\Repository\LootRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LootRepository::class)
 */
class Loot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Monster::class, inversedBy="loots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monster;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="loots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonster(): ?Monster
    {
        return $this->monster;
    }

    public function setMonster(?Monster $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
