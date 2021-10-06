<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenderRepository::class)
 */
class Gender
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
    private $nom_gender;

    /**
     * @ORM\OneToMany(targetEntity=Champion::class, mappedBy="gender", cascade={"remove"})
     */
    private $champions;

    /**
     * @ORM\OneToMany(targetEntity=ImgPerso::class, mappedBy="gender", cascade={"remove"})
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

    public function getNomGender(): ?string
    {
        return $this->nom_gender;
    }

    public function setNomGender(string $nom_gender): self
    {
        $this->nom_gender = $nom_gender;

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
            $champion->setGender($this);
        }

        return $this;
    }

    public function removeChampion(Champion $champion): self
    {
        if ($this->champions->removeElement($champion)) {
            // set the owning side to null (unless already changed)
            if ($champion->getGender() === $this) {
                $champion->setGender(null);
            }
        }

        return $this;
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
            $imgPerso->setGender($this);
        }

        return $this;
    }

    public function removeImgPerso(ImgPerso $imgPerso): self
    {
        if ($this->imgPersos->removeElement($imgPerso)) {
            // set the owning side to null (unless already changed)
            if ($imgPerso->getGender() === $this) {
                $imgPerso->setGender(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_gender;
    }
}
