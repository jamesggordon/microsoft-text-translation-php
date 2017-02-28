<?php
require_once 'Translator.php';

echo "Attempting to translate [hello] to Spanish...\n";

$translator = new Translator();
$spanish = $translator->translate( 'Hello', 'es' );

echo "Translated text: [$spanish]\n";