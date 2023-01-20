<?php

namespace App\Entity;

use App\Repository\ConseilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConseilRepository::class)
 */
class Conseil
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Patient::class, inversedBy="conseils")
     */
    private $patients;

    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="conseil")
     */
    private $questionnaire;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_conseil;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->questionnaire = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        $this->patients->removeElement($patient);

        return $this;
    }

    /**
     * @return Collection<int, Questionnaire>
     */
    public function getQuestionnaire(): Collection
    {
        return $this->questionnaire;
    }

    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        if (!$this->questionnaire->contains($questionnaire)) {
            $this->questionnaire[] = $questionnaire;
            $questionnaire->setConseil($this);
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaire->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getConseil() === $this) {
                $questionnaire->setConseil(null);
            }
        }

        return $this;
    }

    public function getDateConseil(): ?\DateTimeInterface
    {
        return $this->date_conseil;
    }

    public function setDateConseil(?\DateTimeInterface $date_conseil): self
    {
        $this->date_conseil = $date_conseil;

        return $this;
    }
}