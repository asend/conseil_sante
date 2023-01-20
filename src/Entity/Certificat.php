<?php

namespace App\Entity;

use App\Repository\CertificatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificatRepository::class)
 */
class Certificat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avis_traitant;

    // /**
    //  * @ORM\Column(type="text", nullable=true)
    //  */
    // private $decision;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $plainte_doleance;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $examen_clinique;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avis_medecin_conseil;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $examens_complementaires;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $expertise_demandee;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="certificats")
     */
    private $specialite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=Pathologie::class, inversedBy="certificats")
     */
    private $pathologie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="certificats")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvisTraitant(): ?string
    {
        return $this->avis_traitant;
    }

    public function setAvisTraitant(?string $avis_traitant): self
    {
        $this->avis_traitant = $avis_traitant;

        return $this;
    }

    // public function getDecision(): ?string
    // {
    //     return $this->decision;
    // }

    // public function setDecision(?string $decision): self
    // {
    //     $this->decision = $decision;

    //     return $this;
    // }

    public function getPlainteDoleance(): ?string
    {
        return $this->plainte_doleance;
    }

    public function setPlainteDoleance(?string $plainte_doleance): self
    {
        $this->plainte_doleance = $plainte_doleance;

        return $this;
    }

    public function getExamenClinique(): ?string
    {
        return $this->examen_clinique;
    }

    public function setExamenClinique(?string $examen_clinique): self
    {
        $this->examen_clinique = $examen_clinique;

        return $this;
    }

    public function getAvisMedecinConseil(): ?string
    {
        return $this->avis_medecin_conseil;
    }

    public function setAvisMedecinConseil(?string $avis_medecin_conseil): self
    {
        $this->avis_medecin_conseil = $avis_medecin_conseil;

        return $this;
    }

    public function getExamensComplementaires(): ?string
    {
        return $this->examens_complementaires;
    }

    public function setExamensComplementaires(?string $examens_complementaires): self
    {
        $this->examens_complementaires = $examens_complementaires;

        return $this;
    }

    public function getExpertiseDemandee(): ?string
    {
        return $this->expertise_demandee;
    }

    public function setExpertiseDemandee(?string $expertise_demandee): self
    {
        $this->expertise_demandee = $expertise_demandee;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getMedecin(): ?string
    {
        return $this->medecin;
    }

    public function setMedecin(?string $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function hasExpertise(){
        return $this->specialite ? true : false;
    }

    public function isAvailable(){
        return $this->specialite && $this->expertise_demandee ? true : false;
    }

    public function goToSpecialist(){
        return $this->specialite ? true : false;
    }

    public function hasMedecin(){
        return $this->medecin ? true : false;
    }

    public function isComplet(){
        return $this->expertise_demandee && $this->examens_complementaires;
    }

    public function getPathologie(): ?Pathologie
    {
        return $this->pathologie;
    }

    public function setPathologie(?Pathologie $pathologie): self
    {
        $this->pathologie = $pathologie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    
}