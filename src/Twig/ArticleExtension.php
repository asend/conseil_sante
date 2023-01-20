<?php

namespace App\Twig;

use App\Entity\Evasan;
use App\Repository\VisaRepository;
use App\Service\EvasanService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ArticleExtension extends AbstractExtension
{
    private $evasan;
    private $visaRepository;
    public function __construct(EvasanService $evasan, VisaRepository $visaRepository)
    {
        $this->evasan = $evasan;
        $this->visaRepository = $visaRepository;
    }
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
            new TwigFunction('art4', [$this, 'art4']),
            new TwigFunction('art2', [$this, 'art']),
        ];
    }

    public function art1(Evasan $evasan){
        if ($evasan->getQuestionnaire()->getPatient()->getSexe() == 0) {
            $civilite = "Monsieur ";
            $compagnon = "accompagné";
        } else {
            $civilite = "Monsieur ";
            $compagnon = "accompagnée";
        }
        $articlePremier = $civilite." ". $evasan->getQuestionnaire()->getPatient()->getPrenom()." ".$evasan->getQuestionnaire()->getPatient()->getNom().", ".$evasan->getQuestionnaire()->getPatient()->getCorps()->getNom().", matricule de solde ".$evasan->getQuestionnaire()->getPatient()->getMatricule().", en service ".$evasan->getQuestionnaire()->getPatient()->getLieuService()." ".$compagnon." ".$evasan->getAccompagnant()." pour suite thérapeutique.";
        return $articlePremier;
    }

    public function art2(Evasan $evasan){
        $delimiters = [',', 'et'];
        $newstring = str_replace($delimiters, $delimiters[1], $evasan->getAccompagnant());
        $accompagnantArray = explode(" et ", $newstring);
        //$accompagnantArray = preg_split('/[,|et]/', $evasan->getAccompagnant());
        
        $nbrAccompagnant = count($accompagnantArray);
        $nbrBillet = "Deux";
        $accompagnant = $accompagnant = "ses accompagnant(e)s";;
        switch ($nbrAccompagnant) {
            case 1:
                $nbrBillet = "Deux";
                $accompagnant = "son accompagnant(e)";
                break;
            case 2:
                $nbrBillet = "Trois";
                break;
            case 3: 
                $nbrBillet = "Quatre";
                break;
            default:
                $nbrBillet = "Deux";
                break;
        }
        
        return  $nbrBillet." réquisitions de transport DAKAR ".$evasan->getDestination()." DAKAR par voie aérienne, classe touristique, seront accordées à l’intéressé et à ".$accompagnant;
    }

    public function art4(Evasan $evasan)
    {
        $article4 = $this->visaRepository->find(2) ? $this->visaRepository->find(2)->getVisa()." par le canal de l'Ambassade du Sénégal au ".$evasan->getDestination() : "";
        return $article4;
    }
}