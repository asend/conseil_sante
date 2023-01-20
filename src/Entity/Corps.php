<?php

namespace App\Entity;

use App\Repository\CorpsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CorpsRepository::class)
 */
class Corps
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="corps")
     */
    private $patients;

    /**
     * @ORM\ManyToOne(targetEntity=Cadre::class, inversedBy="corps")
     */
    private $cadre;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
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

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setCorps($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getCorps() === $this) {
                $patient->setCorps(null);
            }
        }

        return $this;
    }

    public function getCadre(): ?Cadre
    {
        return $this->cadre;
    }

    public function setCadre(?Cadre $cadre): self
    {
        $this->cadre = $cadre;

        return $this;
    }
}
