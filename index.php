<?php declare(strict_types=1);

$basePath = realpath(__DIR__);
$filePath = $basePath . '/dist';

if (!is_dir($filePath)) {
    umask(000);
    mkdir($filePath, 0775);
}

require $basePath . '/vendor/autoload.php';
require $basePath . '/src/BadgeGenerator.php';
require $basePath . '/src/Request.php';

$request = new Request(getenv('REPOSITORY'));
$healthPercentage = $request->getHealthPercentage();

$image = (new BadgeGenerator($healthPercentage))->generate();
$imagePath = $basePath . $filePath . '/badge.svg';

file_put_contents($imagePath, $image);