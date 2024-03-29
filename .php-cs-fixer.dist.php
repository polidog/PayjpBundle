<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__."/src")
    ->in(__DIR__."/tests")
;
return (new \PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        "@PHP71Migration:risky" => true,
    ])
    ->setFinder($finder)
    ->setLineEnding("\n")
    ;
