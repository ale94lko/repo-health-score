<?php declare(strict_types=1);

$basePath = realpath(__DIR__);
require $basePath . '/vendor/autoload.php';
require $basePath . '/src/BadgeGenerator.php';
require $basePath . '/src/Request.php';

$request = new Request(getenv('REPOSITORY'));
$healthPercentage = $request->getHealthPercentage();

echo (new BadgeGenerator($healthPercentage))->generate();