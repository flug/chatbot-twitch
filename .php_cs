<?php

declare(strict_types=1);

use PedroTroller\CS\Fixer\Fixers;
use PedroTroller\CS\Fixer\RuleSetFactory;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        RuleSetFactory::create()
            ->phpCsFixer(true)
            ->php(7.4, true)
            ->pedrotroller(true)
            ->enable('ordered_imports')
            ->enable('ordered_interfaces')
            ->enable('align_multiline_comment')
            ->enable('array_indentation')
            ->enable('no_superfluous_phpdoc_tags')
            ->enable('binary_operator_spaces', [
                'operators' => [
                    '='  => 'align_single_space_minimal',
                    '=>' => 'align_single_space_minimal',
                ],
            ])
            ->getRules()
    )
    ->setUsingCache(false)
    ->registerCustomFixers(new Fixers())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/src/')
            ->append([__FILE__])
    )
    ;
