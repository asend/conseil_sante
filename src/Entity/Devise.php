<?php

namespace App\Entity;

use App\Repository\DeviseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviseRepository::class)
 */
class Devise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $tau;

    /**
     * @ORM\OneToMany(targetEntity=Evasan::class, mappedBy="devise")
     */
    private $evasans;

    public function __construct()
    {
        $this->evasans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTau(): ?float
    {
        return $this->tau;
    }

    public function setTau(float $tau): self
    {
        $this->tau = $tau;

        return $this;
    }

    /**
     * @return Collection<int, Evasan>
     */
    public function getEvasans(): Collection
    {
        return $this->evasans;
    }

    public function addEvasan(Evasan $evasan): self
    {
        if (!$this->evasans->contains($evasan)) {
            $this->evasans[] = $evasan;
            $evasan->setDevise($this);
        }

        return $this;
    }

    public function removeEvasan(Evasan $evasan): self
    {
        if ($this->evasans->removeElement($evasan)) {
            // set the owning side to null (unless already changed)
            if ($evasan->getDevise() === $this) {
                $evasan->setDevise(null);
            }
        }

        return $this;
    }
}