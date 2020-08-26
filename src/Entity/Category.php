<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity=Sejour::class, mappedBy="categoryId")
     */
    private $sejours;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
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
     * @return Collection|Sejour[]
     */
    public function getSejours(): Collection
    {
        return $this->sejours;
    }

    public function addSejour(Sejour $sejour): self
    {
        if (!$this->sejours->contains($sejour)) {
            $this->sejours[] = $sejour;
            $sejour->setCategory($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejours->contains($sejour)) {
            $this->sejours->removeElement($sejour);
            // set the owning side to null (unless already changed)
            if ($sejour->getCategory() === $this) {
                $sejour->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }


}
