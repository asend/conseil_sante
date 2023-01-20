<?php

namespace App\Twig;

use App\Entity\Conseil;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ConseilExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('listPatient', [$this, 'getListPatient']),
        ];
    }

    public function getListPatient(Conseil $conseil)
    {
        $questionnaires = $conseil->getQuestionnaire();
        $tab = array();
        foreach ($questionnaires as $q) {
            if ($q->getCertificat()) {
                $tab[$q->getQ8()->getNom()][] = $q;
            }
            //$tab[$q->getQ8()->getNom()][] = $q;
        }
        return $tab;
    }
}