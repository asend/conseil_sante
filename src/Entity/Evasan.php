<?php

namespace App\Entity;

use App\Repository\EvasanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvasanRepository::class)
 */
class Evasan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accompagnant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $destination;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montant;

    /**
     * @ORM\OneToOne(targetEntity=Questionnaire::class, cascade={"persist", "remove"})
     */
    private $questionnaire;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_depart;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_retour;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frais_hospitalisation_soins;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rv_controle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_demande;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $n_bordereau_ministere_tutelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $n_date_decision;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $n_facture_date_transmission_solde;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_virement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $n_tresor;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tau;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $facture_pro_format;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $facture_definitive;

    /**
     * @ORM\ManyToOne(targetEntity=Devise::class, inversedBy="evasans")
     */
    private $devise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccompagnant(): ?string
    {
        return $this->accompagnant;
    }

    public function setAccompagnant(?string $accompagnant): self
    {
        $this->accompagnant = $accompagnant;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function isValid(){
        return $this->accompagnant && $this->destination && $this->montant ? true : false;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(?\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    public function setDateRetour(?\DateTimeInterface $date_retour): self
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getFraisHospitalisationSoins(): ?float
    {
        return $this->frais_hospitalisation_soins;
    }

    public function setFraisHospitalisationSoins(?float $frais_hospitalisation_soins): self
    {
        $this->frais_hospitalisation_soins = $frais_hospitalisation_soins;

        return $this;
    }

    public function getRvControle(): ?string
    {
        return $this->rv_controle;
    }

    public function setRvControle(?string $rv_controle): self
    {
        $this->rv_controle = $rv_controle;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->date_demande;
    }

    public function setDateDemande(?\DateTimeInterface $date_demande): self
    {
        $this->date_demande = $date_demande;

        return $this;
    }

    public function getNBordereauMinistereTutelle(): ?string
    {
        return $this->n_bordereau_ministere_tutelle;
    }

    public function setNBordereauMinistereTutelle(?string $n_bordereau_ministere_tutelle): self
    {
        $this->n_bordereau_ministere_tutelle = $n_bordereau_ministere_tutelle;

        return $this;
    }

    public function getNDateDecision(): ?string
    {
        return $this->n_date_decision;
    }

    public function setNDateDecision(?string $n_date_decision): self
    {
        $this->n_date_decision = $n_date_decision;

        return $this;
    }

    public function getNFactureDateTransmissionSolde(): ?string
    {
        return $this->n_facture_date_transmission_solde;
    }

    public function setNFactureDateTransmissionSolde(?string $n_facture_date_transmission_solde): self
    {
        $this->n_facture_date_transmission_solde = $n_facture_date_transmission_solde;

        return $this;
    }

    public function getDateVirement(): ?\DateTimeInterface
    {
        return $this->date_virement;
    }

    public function setDateVirement(?\DateTimeInterface $date_virement): self
    {
        $this->date_virement = $date_virement;

        return $this;
    }

    public function getNTresor(): ?string
    {
        return $this->n_tresor;
    }

    public function setNTresor(?string $n_tresor): self
    {
        $this->n_tresor = $n_tresor;

        return $this;
    }

    public function getTau(): ?string
    {
        return $this->tau;
    }

    public function setTau(?string $tau): self
    {
        $this->tau = $tau;

        return $this;
    }

    public function getFactureProFormat(): ?float
    {
        return $this->facture_pro_format;
    }

    public function setFactureProFormat(?float $facture_pro_format): self
    {
        $this->facture_pro_format = $facture_pro_format;

        return $this;
    }

    public function getFactureDefinitive(): ?float
    {
        return $this->facture_definitive;
    }

    public function setFactureDefinitive(?float $facture_definitive): self
    {
        $this->facture_definitive = $facture_definitive;

        return $this;
    }

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): self
    {
        $this->devise = $devise;

        return $this;
    }
}