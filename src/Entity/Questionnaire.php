<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 */
class Questionnaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $q1;

    /**
     * @ORM\ManyToMany(targetEntity=Demande::class, inversedBy="questionnaires")
     */
    private $q2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $q2autre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $q3;

    /**
     * @ORM\Column(type="boolean")
     */
    private $q4;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $q4datesuspension;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $q3datecessation;

    /**
     * @ORM\Column(type="text")
     */
    private $q5;

    /**
     * @ORM\Column(type="text")
     */
    private $q6;

    /**
     * @ORM\Column(type="text")
     */
    private $q7;

    /**
     * @ORM\ManyToOne(targetEntity=Souhait::class, inversedBy="questionnaires")
     */
    private $q8;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="questionnaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\OneToOne(targetEntity=Certificat::class, cascade={"persist", "remove"})
     */
    private $certificat;

    /**
     * @ORM\ManyToOne(targetEntity=Conseil::class, inversedBy="questionnaire")
     */
    private $conseil;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $demande_traduction;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_conseil;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $decision_conseil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_certificat;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_transmission_resultat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_bordereau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_de_rapprochement;

    public function __construct()
    {
        $this->q2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isQ1(): ?bool
    {
        return $this->q1;
    }

    public function setQ1(bool $q1): self
    {
        $this->q1 = $q1;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getQ2(): Collection
    {
        return $this->q2;
    }

    public function addQ2(Demande $q2): self
    {
        if (!$this->q2->contains($q2)) {
            $this->q2[] = $q2;
        }

        return $this;
    }

    public function removeQ2(Demande $q2): self
    {
        $this->q2->removeElement($q2);

        return $this;
    }

    public function getQ2autre(): ?string
    {
        return $this->q2autre;
    }

    public function setQ2autre(?string $q2autre): self
    {
        $this->q2autre = $q2autre;

        return $this;
    }

    public function isQ3(): ?bool
    {
        return $this->q3;
    }

    public function setQ3(bool $q3): self
    {
        $this->q3 = $q3;

        return $this;
    }

    public function isQ4(): ?bool
    {
        return $this->q4;
    }

    public function setQ4(bool $q4): self
    {
        $this->q4 = $q4;

        return $this;
    }

    public function getQ4datesuspension(): ?\DateTimeInterface
    {
        return $this->q4datesuspension;
    }

    public function setQ4datesuspension(?\DateTimeInterface $q4datesuspension): self
    {
        $this->q4datesuspension = $q4datesuspension;

        return $this;
    }

    public function getQ3datecessation(): ?\DateTimeInterface
    {
        return $this->q3datecessation;
    }

    public function setQ3datecessation(?\DateTimeInterface $q3datecessation): self
    {
        $this->q3datecessation = $q3datecessation;

        return $this;
    }

    public function getQ5(): ?string
    {
        return $this->q5;
    }

    public function setQ5(string $q5): self
    {
        $this->q5 = $q5;

        return $this;
    }

    public function getQ6(): ?string
    {
        return $this->q6;
    }

    public function setQ6(string $q6): self
    {
        $this->q6 = $q6;

        return $this;
    }

    public function getQ7(): ?string
    {
        return $this->q7;
    }

    public function setQ7(string $q7): self
    {
        $this->q7 = $q7;

        return $this;
    }

    public function getQ8(): ?Souhait
    {
        return $this->q8;
    }

    public function setQ8(?Souhait $q8): self
    {
        $this->q8 = $q8;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getCertificat(): ?Certificat
    {
        return $this->certificat;
    }

    public function setCertificat(?Certificat $certificat): self
    {
        $this->certificat = $certificat;

        return $this;
    }

    public function getConseil(): ?Conseil
    {
        return $this->conseil;
    }

    public function setConseil(?Conseil $conseil): self
    {
        $this->conseil = $conseil;

        return $this;
    }

    public function getDemandeTraduction(): ?string
    {
        return $this->demande_traduction;
    }

    public function setDemandeTraduction(string $demande_traduction): self
    {
        $this->demande_traduction = $demande_traduction;

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

    public function getDecisionConseil(): ?string
    {
        return $this->decision_conseil;
    }

    public function setDecisionConseil(?string $decision_conseil): self
    {
        $this->decision_conseil = $decision_conseil;

        return $this;
    }

    public function getNumeroCertificat(): ?string
    {
        return $this->numero_certificat;
    }

    public function setNumeroCertificat(?string $numero_certificat): self
    {
        $this->numero_certificat = $numero_certificat;

        return $this;
    }

    public function getDateTransmissionResultat(): ?\DateTimeInterface
    {
        return $this->date_transmission_resultat;
    }

    public function setDateTransmissionResultat(?\DateTimeInterface $date_transmission_resultat): self
    {
        $this->date_transmission_resultat = $date_transmission_resultat;

        return $this;
    }

    public function getNumeroBordereau(): ?string
    {
        return $this->numero_bordereau;
    }

    public function setNumeroBordereau(?string $numero_bordereau): self
    {
        $this->numero_bordereau = $numero_bordereau;

        return $this;
    }

    public function getLieuDeRapprochement(): ?string
    {
        return $this->lieu_de_rapprochement;
    }

    public function setLieuDeRapprochement(?string $lieu_de_rapprochement): self
    {
        $this->lieu_de_rapprochement = $lieu_de_rapprochement;

        return $this;
    }
}