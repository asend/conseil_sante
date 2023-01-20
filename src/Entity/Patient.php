<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    const SM = [
        0 => 'CELIBATAIRE',
        1 => 'MARIE(E)',
        2 => 'DIVORCE(E)',
        3 => 'VEUF',
        4 => 'VEUVE'
    ];

    const GRADE = [
        0 => '5cl/1ech',
        1 => '5cl/2ech',
        2 => '5cl/3ech',
        3 => '5cl/4ech',
        4 => '5cl/5ech'
    ];

    const SEXE = [
        0 => 'MASCULIN',
        1 => 'FEMININ'
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lieu_naissance;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_service;

    /**
     * @ORM\Column(type="date")
     */
    private $date_entree_service;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_enfant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone_bureau;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone_personnel;

    /**
     * @ORM\ManyToOne(targetEntity=Ministere::class, inversedBy="patients")
     */
    private $tutel;

    /**
     * @ORM\ManyToOne(targetEntity=Corps::class, inversedBy="patients")
     */
    private $corps;

    /**
     * @ORM\Column(type="integer")
     */
    private $situation_matrimoniale;

    /**
     * @ORM\Column(type="integer")
     */
    private $grade;

    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="patient")
     */
    private $questionnaires;

    /**
     * @ORM\ManyToMany(targetEntity=Conseil::class, mappedBy="patients")
     */
    private $conseils;

    /**
     * @ORM\ManyToOne(targetEntity=Cadre::class, inversedBy="patients")
     */
    private $cadre;

    /**
     * @ORM\Column(type="integer")
     */
    private $sexe;

    public function __construct()
    {
        $this->questionnaires = new ArrayCollection();
        $this->conseils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(string $lieu_naissance): self
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getLieuService(): ?string
    {
        return $this->lieu_service;
    }

    public function setLieuService(string $lieu_service): self
    {
        $this->lieu_service = $lieu_service;

        return $this;
    }

    public function getDateEntreeService(): ?\DateTimeInterface
    {
        return $this->date_entree_service;
    }

    public function setDateEntreeService(\DateTimeInterface $date_entree_service): self
    {
        $this->date_entree_service = $date_entree_service;

        return $this;
    }

    public function getNombreEnfant(): ?int
    {
        return $this->nombre_enfant;
    }

    public function setNombreEnfant(int $nombre_enfant): self
    {
        $this->nombre_enfant = $nombre_enfant;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephoneBureau(): ?string
    {
        return $this->telephone_bureau;
    }

    public function setTelephoneBureau(?string $telephone_bureau): self
    {
        $this->telephone_bureau = $telephone_bureau;

        return $this;
    }

    public function getTelephonePersonnel(): ?string
    {
        return $this->telephone_personnel;
    }

    public function setTelephonePersonnel(?string $telephone_personnel): self
    {
        $this->telephone_personnel = $telephone_personnel;

        return $this;
    }

    public function getTutel(): ?Ministere
    {
        return $this->tutel;
    }

    public function setTutel(?Ministere $tutel): self
    {
        $this->tutel = $tutel;

        return $this;
    }

    public function getCorps(): ?Corps
    {
        return $this->corps;
    }

    public function setCorps(?Corps $corps): self
    {
        $this->corps = $corps;

        return $this;
    }

    public function getSituationMatrimoniale(): ?int
    {
        return $this->situation_matrimoniale;
    }

    public function setSituationMatrimoniale(int $situation_matrimoniale): self
    {
        $this->situation_matrimoniale = $situation_matrimoniale;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, Questionnaire>
     */
    public function getQuestionnaires(): Collection
    {
        return $this->questionnaires;
    }

    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires[] = $questionnaire;
            $questionnaire->setPatient($this);
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaires->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getPatient() === $this) {
                $questionnaire->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conseil>
     */
    public function getConseils(): Collection
    {
        return $this->conseils;
    }

    public function addConseil(Conseil $conseil): self
    {
        if (!$this->conseils->contains($conseil)) {
            $this->conseils[] = $conseil;
            $conseil->addPatient($this);
        }

        return $this;
    }

    public function removeConseil(Conseil $conseil): self
    {
        if ($this->conseils->removeElement($conseil)) {
            $conseil->removePatient($this);
        }

        return $this;
    }

    public function getSM($value){
        return Patient::SM[$value];
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

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }
}