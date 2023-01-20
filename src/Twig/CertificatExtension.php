<?php

namespace App\Twig;

use App\Entity\Certificat;
use App\Entity\Questionnaire;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CertificatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getCert', [$this, 'getCert']),
            new TwigFilter('isExist', [$this, 'isExist']),
            new TwigFilter('getExpertStatus', [$this, 'getExpertStatus']),
            
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getStatus', [$this, 'getStatus']),
        ];
    }

    public function getCert(Certificat $certificat)
    {
        $result = 0;
        /** si la le champs specialité est renseigné */
        if ($certificat->hasExpertise()) {
            /** si le resultat de l'expertise est renseigné  */
            if($certificat->isAvailable()){
                $result = 2;
            }else {
                $result = 1;
            }
        } else {
            $result = 0;
        }
        return $result;
    }

    public function getExpertStatus(Certificat $certificat)
    {
        $result = 0;
        /** si la le champs specialité est renseigné */
        // if($certificat->goToSpecialist()){
        //     if($certificat->hasMedecin()){
        //         $result = 1; // couleur du tr en vert c'est à dire la spécialité et le medecin qui doit faire l'expertise sont déjà choisi 
        //     }else {
        //         $result = 2; // couleur du tr en rouge specialité choisit mais pas encore le médecin
        //     }
        // }elseif ($certificat->isComplet()) {
        //     $result = 3;
        // }else{
        //     $result = 0;
        // }

        if($certificat->goToSpecialist()){
            if($certificat->hasMedecin()){
                //$result = 1; // couleur du tr en vert c'est à dire la spécialité et le medecin qui doit faire l'expertise sont déjà choisi 
                if ($certificat->isComplet()) {
                    $result = 3;
                }else{
                    $result = 1;
                }
               // $result = 1;
                
            }else {
                $result = 2; // couleur du tr en rouge specialité choisit mais pas encore le médecin
            }
        }
        

        // if ($certificat->isComplet()) {
        //     $result = 0;
        // }
        // if($certificat->goToSpecialist() && $certificat)
        // if ($certificat->hasExpertise()) {
        //     /** si le resultat de l'expertise est renseigné  */
        //     if($certificat->isAvailable()){
        //         $result = 2;
        //     }else {
        //         $result = 1;
        //     }
        // } else {
        //     $result = 0;
        // }
        return $result;
    }

    public function isExist(Questionnaire $questionnaire){
        if ($questionnaire->getCertificat()) {
            return true;
        } 
        return false;
        
    }

    public function getStatus(Certificat $certificat){
        return $certificat->getId();
    }
}