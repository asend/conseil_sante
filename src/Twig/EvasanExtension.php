<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Service\EvasanService;
use Twig\Extension\AbstractExtension;

class EvasanExtension extends AbstractExtension
{
    private $evasan;
    public function __construct(EvasanService $evasan)
    {
        $this->evasan = $evasan;
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
            new TwigFunction('getEvasan', [$this, 'getEvasan']),
            new TwigFunction('isEvasan', [$this, 'isEvasan']),
        ];
    }

    public function getEvasan($id)
    {
        return $this->evasan->evasanByQuestionnaire($id);
    }

    public function isEvasan($id)
    {
        if ($this->evasan->evasanByQuestionnaire($id)) {
            return true;
        } else {
            return false;
        }
    }
}