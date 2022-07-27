<?php

use PUGX\Poser\Poser;
use PUGX\Poser\Render\SvgFlatRender;
use PUGX\Poser\Render\SvgFlatSquareRender;
use PUGX\Poser\Render\SvgForTheBadgeRenderer;
use PUGX\Poser\Render\SvgPlasticRender;

final class BadgeGenerator
{
    const LABEL = 'health score';
    const BADGE_STYLE = 'flat';

    private Poser $poser;
    private string $healthPercentage;

    /**
     * @param string $healthPercentage
     */
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

    /**
     * @return string
     */
    public function generate(): string
    {
        return (string) $this->poser->generate(
            self::LABEL,
            $this->healthPercentage,
            $this->getColor(),
            self::BADGE_STYLE
        );
    }

    /**
     * @return string
     */
    private function getColor(): string
    {
        switch (intval(intval($this->healthPercentage) / 25)) {
            case 4:
                $color = 'blue';
                break;

            case 3:
                $color = 'green';
                break;

            case 2:
                $color = 'yellow';
                break;

            default:
                $color = 'red';
                break;
        }

        return $color;
    }
}