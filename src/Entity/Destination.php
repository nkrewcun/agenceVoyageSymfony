<?php

namespace App\Entity;

use App\Repository\DestinationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DestinationRepository::class)
 */
class Destination
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le lieu est requis")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le type est requis")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le pays est requis")
     */
    private $pays;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Le format de la date est invalide")
     */
    private $dateOuverture;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull(message="La note est requise")
     * @Assert\Range(min=1, max=5, notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}")
     */
    private $nbStar;

    /**
     * @ORM\OneToOne(targetEntity=Sejour::class, inversedBy="destination", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sejour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu($lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays($pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(?\DateTimeInterface $dateOuverture): self
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    public function getNbStar(): ?int
    {
        return $this->nbStar;
    }

    public function setNbStar($nbStar): self
    {
        $this->nbStar = $nbStar;

        return $this;
    }

    public function getSejour(): ?sejour
    {
        return $this->sejour;
    }

    public function setSejour($sejour): self
    {
        $this->sejour = $sejour;

        return $this;
    }
}
