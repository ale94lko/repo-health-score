<?php

declare(strict_types=1);

$basePath = realpath(__DIR__);
$filePath = $basePath . '/dist';

if (!is_dir($filePath)) {
    mkdir($filePath, 0775, true);
}

require $basePath . '/vendor/autoload.php';
require $basePath . '/src/BadgeGenerator.php';
require $basePath . '/src/Request.php';

$repository = getenv('REPOSITORY') ?: '';
$token = getenv('GITHUB_TOKEN') ?: '';

$request = new Request($repository, $token);
$healthPercentage = $request->getHealthPercentage();

$image = (new BadgeGenerator($healthPercentage))->generate();
$imagePath = $filePath . '/badge.svg';

file_put_contents($imagePath, $image);
