<?php

namespace App\Twig;

use App\Entity\Questionnaire;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ReponseExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('q1', [$this, 'getQ1']),
            new TwigFilter('q3', [$this, 'getQ3']),
            new TwigFilter('q4', [$this, 'getQ4']),
        ];
    }

    public function getQ1s(Questionnaire $questionnaire): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function getQ1(Questionnaire $questionnaire)
    {
        if ($questionnaire->isQ1()) {
            return "OUI";
        }else{
            return "NON";
        }
    }
}