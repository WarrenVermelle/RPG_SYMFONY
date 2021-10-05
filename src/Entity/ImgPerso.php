<?php

namespace App\Entity;

use App\Repository\ImgPersoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ImgPersoRepository::class)
 * @Vich\Uploadable()
 */
class ImgPerso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="imgPersos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class, inversedBy="imgPersos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * 
     * @Vich\UploadableField(mapping="imgperso", fileNameProperty="img")
     * 
     * @var File|null
     */
    private $file_img;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $img;

    /**
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="imgPersos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

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

    public function getFileImg(): ?File
    {
        return $this->file_img;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileImg(?File $imageFile = null): void
    {
        $this->file_img = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
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

    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  \DateTimeInterface|null
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTimeInterface|null  $updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
