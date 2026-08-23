<?php

declare(strict_types=1);

use PUGX\Poser\Poser;
use PUGX\Poser\Render\SvgFlatRender;
use PUGX\Poser\Render\SvgFlatSquareRender;
use PUGX\Poser\Render\SvgForTheBadgeRenderer;
use PUGX\Poser\Render\SvgPlasticRender;

final class BadgeGenerator
{
    private const LABEL = 'health score';
    private const BADGE_STYLE = 'flat';

    private Poser $poser;
    private string $healthPercentage;

    public function __construct(string $healthPercentage)
    {
        $this->poser = new Poser([
            new SvgPlasticRender(),
            new SvgFlatRender(),
            new SvgFlatSquareRender(),
            new SvgForTheBadgeRenderer(),
        ]);
        $this->healthPercentage = $healthPercentage;
    }

    public function generate(): string
    {
        return (string) $this->poser->generate(
            self::LABEL,
            $this->healthPercentage,
            $this->getColor(),
            self::BADGE_STYLE
        );
    }

    private function getColor(): string
    {
        $score = (int) $this->healthPercentage;

        if ($score >= 100) {
            return 'brightgreen';
        }

        if ($score >= 75) {
            return 'green';
        }

        if ($score >= 50) {
            return 'yellow';
        }

        if ($score >= 25) {
            return 'orange';
        }

        return 'red';
    }
}
