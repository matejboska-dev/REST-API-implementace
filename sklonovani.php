<?php

require __DIR__ . '/vendor/autoload.php';

$vocative = new Granam\CzechVocative\CzechName(); 
// Základní nastavení NameCase které používám já, více v dokumentaci
Tamtamchik\NameCase\Formatter::setOptions([ 'Czech' => false, 'lazy' => false ]);

echo $vocative->vocative('Votava'); // => pavle

?>

>