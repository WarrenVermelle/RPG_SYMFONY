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
    private $map_top;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $map_right;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $map_bottom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $map_left;

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

    public function getMapTop(): ?int
    {
        return $this->map_top;
    }

    public function setMapTop(?int $map_top): self
    {
        $this->top = $map_top;

        return $this;
    }

    public function getMapRight(): ?int
    {
        return $this->map_right;
    }

    public function setMapRight(?int $map_right): self
    {
        $this->map_right = $map_right;

        return $this;
    }

    public function getMapBottom(): ?int
    {
        return $this->map_bottom;
    }

    public function setMapBottom(?int $map_bottom): self
    {
        $this->map_bottom = $map_bottom;

        return $this;
    }

    public function getMapLeft(): ?int
    {
        return $this->map_left;
    }

    public function setMapLeft(?int $map_left): self
    {
        $this->map_left = $map_left;

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

}
