<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withConfiguredRule(
        ArraySyntaxFixer::class,
        ['syntax' => 'short']
    )
    // add a single rule
    ->withRules([
        ListSyntaxFixer::class,
    ])
    ->withPreparedSets(psr12: true);
    // add sets - group of rules
   // ->withPreparedSets(
        // arrays: true,
        // namespaces: true,
        // spaces: true,
        // docblocks: true,
        // comments: true,
    // )
     ;
