<?php

namespace App\Service;

use App\Repository\QuestionnaireRepository;

class QuestionnaireService
{

    private $questionnaireRepository;
    public function __construct(QuestionnaireRepository $questionnaireRepository){
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function questionnaireByPatientAndConseil($idC, $idP){
        return $this->questionnaireRepository->findByPatientAndConseil($idC, $idP);
    }

    public function questionnaireByCertificat($idC){
        return $this->questionnaireRepository->findByCertificat($idC);
    }

    public function questionnaireByConseilWithDecision($idC){
        return $this->questionnaireRepository->findByConseilWithDecision($idC);
    }
}