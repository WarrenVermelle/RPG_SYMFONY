<?php

namespace App\Entity;

use App\Entity\Abstract\Humanoide;
use App\Repository\ChampionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChampionRepository::class)
 */
class Champion
{
    

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $gender;

    /**
     * @ORM\Column(type="text")
     */
    private $img;

    /**
<<<<<<< HEAD
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="champ")
=======
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $gold;

    /**
     * @ORM\Column(type="integer")
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     */
    private $mp;

    /**
     * @ORM\Column(type="integer")
     */
    private $intel;

    /**
     * @ORM\Column(type="integer")
     */
    private $strength;

    /**
     * @ORM\Column(type="integer")
     */
    private $agi;

    /**
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="champ", cascade={"persist","remove"})
>>>>>>> a201143ccf7ef4e645ce4692d47c72c8b6353655
     */
    private $inventories;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="champions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class, inversedBy="champions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="champions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

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

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
            $newInventory = new Inventory();
            $newInventory ->setEquiped(false);
            $newInventory -> setItem($inventory->getItem());
            $this->inventories[] = $newInventory;
            $newInventory ->setChamp($this);

        return $this;
    }

    /*
    ** On passe le manager afin de suprimer l'objet d'une table many to many plus avancé
    */
    public function removeInventory(Inventory $inventory, $manager): self
    {
        if ($this->inventories->removeElement($inventory)) {
            $manager->remove($inventory);            
        }
        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    use Humanoide;
}
