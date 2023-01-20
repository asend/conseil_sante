<?php

namespace App\Entity;

use App\Repository\CadreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CadreRepository::class)
 */
class Cadre
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
     * @ORM\OneToMany(targetEntity=Corps::class, mappedBy="cadre")
     */
    private $corps;

    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="cadre")
     */
    private $patients;

    public function __construct()
    {
        $this->corps = new ArrayCollection();
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
     * @return Collection<int, Corps>
     */
    public function getCorps(): Collection
    {
        return $this->corps;
    }

    public function addCorps(Corps $corps): self
    {
        if (!$this->corps->contains($corps)) {
            $this->corps[] = $corps;
            $corps->setCadre($this);
        }

        return $this;
    }

    public function removeCorps(Corps $corps): self
    {
        if ($this->corps->removeElement($corps)) {
            // set the owning side to null (unless already changed)
            if ($corps->getCadre() === $this) {
                $corps->setCadre(null);
            }
        }

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
            $patient->setCadre($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getCadre() === $this) {
                $patient->setCadre(null);
            }
        }

        return $this;
    }
}
