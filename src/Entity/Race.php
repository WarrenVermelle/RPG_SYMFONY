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
     * @ORM\OneToMany(targetEntity=Champion::class, mappedBy="race")
     */
    private $champions;

    /**
     * 
     * @Vich\UploadableField(mapping="champions", fileNameProperty="img_HumainH")
     * 
     * @var File|null
     */
    private $file_humainH;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $img_HumainH;

    /**
     * 
     * @Vich\UploadableField(mapping="champions", fileNameProperty="img_HumainF")
     * 
     * @var File|null
     */
    private $file_humainF;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $img_HumainF;

    /**
     * 
     * @Vich\UploadableField(mapping="champions", fileNameProperty="img_ElfH")
     * 
     * @var File|null
     */
    private $file_elfH;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $img_ElfH;

    /**
     * 
     * @Vich\UploadableField(mapping="champions", fileNameProperty="img_ElfF")
     * 
     * @var File|null
     */
    private $file_elfF;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $img_ElfF;

    /**
     * 
     * @Vich\UploadableField(mapping="champions", fileNameProperty="img_OrcH")
     * 
     * @var File|null
     */
    private $file_orcH;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $img_OrcH;

    /**
     * 
     * @Vich\UploadableField(mapping="champions", fileNameProperty="img_OrcF")
     * 
     * @var File|null
     */
    private $file_orcF;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $img_OrcF;

     /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    public function __construct()
    {
        $this->champions = new ArrayCollection();
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

    public function getFileHumainH(): ?File
    {
        return $this->file_humainH;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileHumainH(?File $imageFile = null): void
    {
        $this->file_humainH = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of img_HumainH
     *
     * @return  string|null
     */ 
    public function getImgHumainH()
    {
        return $this->img_HumainH;
    }

    /**
     * Set the value of img_HumainH
     *
     * @param  string|null  $img_HumainH
     *
     * @return  self
     */ 
    public function setImgHumainH($img_HumainH)
    {
        $this->img_HumainH = $img_HumainH;

        return $this;
    }

    public function getFileHumainF(): ?File
    {
        return $this->file_humainF;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileHumainF(?File $imageFile = null): void
    {
        $this->file_humainF = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of img_HumainF
     *
     * @return  string|null
     */ 
    public function getImgHumainF()
    {
        return $this->img_HumainF;
    }

    /**
     * Set the value of img_HumainF
     *
     * @param  string|null  $img_HumainF
     *
     * @return  self
     */ 
    public function setImgHumainF($img_HumainF)
    {
        $this->img_HumainF = $img_HumainF;

        return $this;
    }

    public function getFileElfH(): ?File
    {
        return $this->file_elfH;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileElfH(?File $imageFile = null): void
    {
        $this->file_elfH = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of img_ElfH
     *
     * @return  string|null
     */ 
    public function getImgElfH()
    {
        return $this->img_ElfH;
    }

    /**
     * Set the value of img_ElfH
     *
     * @param  string|null  $img_ElfH
     *
     * @return  self
     */ 
    public function setImgElfH($img_ElfH)
    {
        $this->img_ElfH = $img_ElfH;

        return $this;
    }

    public function getFileElfF(): ?File
    {
        return $this->file_elfF;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileElfF(?File $imageFile = null): void
    {
        $this->file_elfF = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of img_ElfF
     *
     * @return  string|null
     */ 
    public function getImgElfF()
    {
        return $this->img_ElfF;
    }

    /**
     * Set the value of img_ElfF
     *
     * @param  string|null  $img_ElfF
     *
     * @return  self
     */ 
    public function setImgElfF($img_ElfF)
    {
        $this->img_ElfF = $img_ElfF;

        return $this;
    }

    public function getFileOrcH(): ?File
    {
        return $this->file_orcH;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileOrcH(?File $imageFile = null): void
    {
        $this->file_orcH = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of img_OrcH
     *
     * @return  string|null
     */ 
    public function getImgOrcH()
    {
        return $this->img_OrcH;
    }

    /**
     * Set the value of img_OrcH
     *
     * @param  string|null  $img_OrcH
     *
     * @return  self
     */ 
    public function setImgOrcH($img_OrcH)
    {
        $this->img_OrcH = $img_OrcH;

        return $this;
    }

    public function getFileOrcF(): ?File
    {
        return $this->file_orcF;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFileOrcF(?File $imageFile = null): void
    {
        $this->file_orcF = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of img_OrcF
     *
     * @return  string|null
     */ 
    public function getImgOrcF()
    {
        return $this->img_OrcF;
    }

    /**
     * Set the value of img_OrcF
     *
     * @param  string|null  $img_OrcF
     *
     * @return  self
     */ 
    public function setImgOrcF($img_OrcF)
    {
        $this->img_OrcF = $img_OrcF;

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
