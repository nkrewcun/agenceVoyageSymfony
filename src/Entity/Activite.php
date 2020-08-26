<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le nom est requis")
     * @Assert\Length(min=3, minMessage="Il faut au moins 3 caractères")
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Sejour::class, inversedBy="activites")
     */
    private $sejourId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     maxSize = "5M",
     *     maxSizeMessage= "Le fichier ne doit pas dépasser 5 Mo",
     *     mimeTypes = {"image/png", "image/jpeg", "image/gif"},
     *     mimeTypesMessage = "Le fichier doit être une image"
     * )
     */
    private $image;

    public function __construct()
    {
        $this->sejourId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom($nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|sejour[]
     */
    public function getSejourId(): Collection
    {
        return $this->sejourId;
    }

    public function addSejourId(sejour $sejourId): self
    {
        if (!$this->sejourId->contains($sejourId)) {
            $this->sejourId[] = $sejourId;
        }

        return $this;
    }

    public function removeSejourId(sejour $sejourId): self
    {
        if ($this->sejourId->contains($sejourId)) {
            $this->sejourId->removeElement($sejourId);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }


}
