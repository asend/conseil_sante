<?php

namespace App\Service;

use App\Repository\EvasanRepository;
use App\Repository\QuestionnaireRepository;

class EvasanService
{

    private $evasanRepository;
    public function __construct(EvasanRepository $evasanRepository){
        $this->evasanRepository = $evasanRepository;
    }

    public function evasanByQuestionnaire($id){
        return $this->evasanRepository->findByQuestionnaire($id);
    }
}