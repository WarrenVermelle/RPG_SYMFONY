<?php

namespace App\Entity;

use App\Repository\MapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MapRepository::class)
 */
class Map
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $map_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $shop;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fight;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $marchand;

    /**
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="maps")
     */
    private $map_top;

    /**
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="maps_right")
     */
    private $map_right;

    /**
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="map_bot")
     */
    private $map_bottom;

    /**
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="maps")
     */
    private $map_left;

    /**
     * @ORM\OneToMany(targetEntity=Map::class, mappedBy="map_left")
     */
    private $maps;

    public function __construct()
    {
        $this->maps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMapName(): ?string
    {
        return $this->map_name;
    }

    public function setMapName(string $map_name): self
    {
        $this->map_name = $map_name;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getShop(): ?int
    {
        return $this->shop;
    }

    public function setShop(?int $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getFight(): ?bool
    {
        return $this->fight;
    }

    public function setFight(?bool $fight): self
    {
        $this->fight = $fight;

        return $this;
    }

    public function getMarchand(): ?bool
    {
        return $this->marchand;
    }

    public function setMarchand(?bool $marchand): self
    {
        $this->marchand = $marchand;

        return $this;
    }

    public function getMapTop(): ?self
    {
        return $this->map_top;
    }

    public function setMapTop(?self $map_top): self
    {
        $this->map_top = $map_top;

        return $this;
    }

    public function getMapRight(): ?self
    {
        return $this->map_right;
    }

    public function setMapRight(?self $map_right): self
    {
        $this->map_right = $map_right;

        return $this;
    }

    public function getMapBottom(): ?self
    {
        return $this->map_bottom;
    }

    public function setMapBottom(?self $map_bottom): self
    {
        $this->map_bottom = $map_bottom;

        return $this;
    }

    public function getMapLeft(): ?self
    {
        return $this->map_left;
    }

    public function setMapLeft(?self $map_left): self
    {
        $this->map_left = $map_left;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMaps(): Collection
    {
        return $this->maps;
    }

    public function addMap(self $map): self
    {
        if (!$this->maps->contains($map)) {
            $this->maps[] = $map;
            $map->setMapLeft($this);
        }

        return $this;
    }

    public function removeMap(self $map): self
    {
        if ($this->maps->removeElement($map)) {
            // set the owning side to null (unless already changed)
            if ($map->getMapLeft() === $this) {
                $map->setMapLeft(null);
            }
        }

        return $this;
    }

}
