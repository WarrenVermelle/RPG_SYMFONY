<?php

namespace App\Entity;

use App\Repository\FactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactionRepository::class)
 */
class Faction
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
    private $faction;

    /**
     * @ORM\Column(type="float")
     */
    private $coef_hp;

    /**
     * @ORM\Column(type="float")
     */
    private $coef_mp;

    /**
     * @ORM\Column(type="float")
     */
    private $coef_intel;

    /**
     * @ORM\Column(type="float")
     */
    private $coef_strength;

    /**
     * @ORM\Column(type="float")
     */
    private $coef_agi;

    /**
     * @ORM\OneToMany(targetEntity=Champion::class, mappedBy="faction")
     */
    private $champions;

    public function __construct()
    {
        $this->champions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFaction(): ?string
    {
        return $this->faction;
    }

    public function setFaction(string $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    public function getCoefHp(): ?float
    {
        return $this->coef_hp;
    }

    public function setCoefHp(float $coef_hp): self
    {
        $this->coef_hp = $coef_hp;

        return $this;
    }

    public function getCoefMp(): ?float
    {
        return $this->coef_mp;
    }

    public function setCoefMp(float $coef_mp): self
    {
        $this->coef_mp = $coef_mp;

        return $this;
    }

    public function getCoefIntel(): ?float
    {
        return $this->coef_intel;
    }

    public function setCoefIntel(float $coef_intel): self
    {
        $this->coef_intel = $coef_intel;

        return $this;
    }

    public function getCoefStrength(): ?float
    {
        return $this->coef_strength;
    }

    public function setCoefStrength(float $coef_strength): self
    {
        $this->coef_strength = $coef_strength;

        return $this;
    }

    public function getCoefAgi(): ?float
    {
        return $this->coef_agi;
    }

    public function setCoefAgi(float $coef_agi): self
    {
        $this->coef_agi = $coef_agi;

        return $this;
    }

    /**
     * @return Collection|Champion[]
     */
    public function getChampions(): Collection
    {
        return $this->champions;
    }

    public function addChampion(Champion $champion): self
    {
        if (!$this->champions->contains($champion)) {
            $this->champions[] = $champion;
            $champion->setFaction($this);
        }

        return $this;
    }

    public function removeChampion(Champion $champion): self
    {
        if ($this->champions->removeElement($champion)) {
            // set the owning side to null (unless already changed)
            if ($champion->getFaction() === $this) {
                $champion->setFaction(null);
            }
        }

        return $this;
    }
}
