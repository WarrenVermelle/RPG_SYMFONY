<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $equiped;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class, inversedBy="inventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $champ;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="inventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquiped(): ?bool
    {
        return $this->equiped;
    }

    public function setEquiped(bool $equiped): self
    {
        $this->equiped = $equiped;

        return $this;
    }

    public function getChamp(): ?Champion
    {
        return $this->champ;
    }

    public function setChamp(?Champion $champ): self
    {
        $this->champ = $champ;

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
