<?php

namespace App\Entity;

use App\Repository\SejourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SejourRepository::class)
 */
class Sejour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le type de logement est requis")
     */
    private $typeLogement;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Le nombre doit être positif")
     */
    private $nbPersonne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le titre est requis")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull(message="La description est requise")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="La catégorie est requise")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=Destination::class, mappedBy="sejour", cascade={"persist", "remove"})
     */
    private $destination;

    /**
     * @ORM\ManyToMany(targetEntity=Activite::class, mappedBy="sejourId")
     */
    private $activites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeLogement(): ?string
    {
        return $this->typeLogement;
    }

    public function setTypeLogement($typeLogement): self
    {
        $this->typeLogement = $typeLogement;

        return $this;
    }

    public function getNbPersonne(): ?int
    {
        return $this->nbPersonne;
    }

    public function setNbPersonne($nbPersonne): self
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre($titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination($destination): self
    {
        $this->destination = $destination;

        // set the owning side of the relation if necessary
        if ($destination->getSejour() !== $this) {
            $destination->setSejour($this);
        }

        return $this;
    }

    /**
     * @return Collection|Activite[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->addSejourId($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->contains($activite)) {
            $this->activites->removeElement($activite);
            $activite->removeSejourId($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;

    }


}
