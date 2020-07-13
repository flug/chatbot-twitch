<?php

/*
 * This file is part of the Chatbot project.
 *
 * (c) Lemay Marc <flugv1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

$header = <<<'HEADER'
    This file is part of the Chatbot project.

    (c) Lemay Marc <flugv1@gmail.com>

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    HEADER;
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
            ->enable('header_comment', [
                'header'   => $header,
                'location' => 'after_open',
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
