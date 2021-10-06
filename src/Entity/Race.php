<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=RaceRepository::class)
 * @Vich\Uploadable()
 */
class Race
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
    private $race;

    /**
     * @ORM\Column(type="float")
     */
    private $ratio_hp;

    /**
     * @ORM\Column(type="float")
     */
    private $ratio_mp;

    /**
     * @ORM\Column(type="float")
     */
    private $ratio_intel;

    /**
     * @ORM\Column(type="float")
     */
    private $ratio_strength;

    /**
     * @ORM\Column(type="float")
     */
    private $ratio_agi;

    /**
     * @ORM\OneToMany(targetEntity=Champion::class, mappedBy="race", cascade={"remove"})
     */
    private $champions;

    /**
     * @ORM\OneToMany(targetEntity=ImgPerso::class, mappedBy="race", cascade={"remove"})
     */
    private $imgPersos;

    
    public function __construct()
    {
        $this->champions = new ArrayCollection();
        $this->imgPersos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getRatioHp(): ?float
    {
        return $this->ratio_hp;
    }

    public function setRatioHp(float $ratio_hp): self
    {
        $this->ratio_hp = $ratio_hp;

        return $this;
    }

    public function getRatioMp(): ?float
    {
        return $this->ratio_mp;
    }

    public function setRatioMp(float $ratio_mp): self
    {
        $this->ratio_mp = $ratio_mp;

        return $this;
    }

    public function getRatioIntel(): ?float
    {
        return $this->ratio_intel;
    }

    public function setRatioIntel(float $ratio_intel): self
    {
        $this->ratio_intel = $ratio_intel;

        return $this;
    }

    public function getRatioStrength(): ?float
    {
        return $this->ratio_strength;
    }

    public function setRatioStrength(float $ratio_strength): self
    {
        $this->ratio_strength = $ratio_strength;

        return $this;
    }

    public function getRatioAgi(): ?float
    {
        return $this->ratio_agi;
    }

    public function setRatioAgi(float $ratio_agi): self
    {
        $this->ratio_agi = $ratio_agi;

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
            $champion->setRace($this);
        }

        return $this;
    }

    public function removeChampion(Champion $champion): self
    {
        if ($this->champions->removeElement($champion)) {
            // set the owning side to null (unless already changed)
            if ($champion->getRace() === $this) {
                $champion->setRace(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->race;
    }

    /**
     * @return Collection|ImgPerso[]
     */
    public function getImgPersos(): Collection
    {
        return $this->imgPersos;
    }

    public function addImgPerso(ImgPerso $imgPerso): self
    {
        if (!$this->imgPersos->contains($imgPerso)) {
            $this->imgPersos[] = $imgPerso;
            $imgPerso->setRace($this);
        }

        return $this;
    }

    public function removeImgPerso(ImgPerso $imgPerso): self
    {
        if ($this->imgPersos->removeElement($imgPerso)) {
            // set the owning side to null (unless already changed)
            if ($imgPerso->getRace() === $this) {
                $imgPerso->setRace(null);
            }
        }

        return $this;
    }
}
