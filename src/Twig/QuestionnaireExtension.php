<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Service\QuestionnaireService;
use Twig\Extension\AbstractExtension;

class QuestionnaireExtension extends AbstractExtension
{
    private $qs;
    public function __construct(QuestionnaireService $qs)
    {
        $this->qs = $qs;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getQuestionnaire', [$this, 'getQuestionnaire']),
            new TwigFunction('getQuestionnaireByCertificat', [$this, 'getQuestionnaireByCertificat']),
        ];
    }
    /**
     *
     * @param int $idC
     * @param int $idP
     * @return Questionnaire | NULL
     */
    public function getQuestionnaire($idC, $idP)
    {
        return $this->qs->questionnaireByPatientAndConseil($idC, $idP);
    }

    /**
     * @param int $idC
     * @return Questionnaire | NULL
     */

    public function getQuestionnaireByCertificat($idC){
        return $this->qs->questionnaireByCertificat($idC);
    }
}