<?php

use PhpCsFixer\{Config, Finder};

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'group_import' => true,
        'no_unused_imports' => true,
        'blank_line_after_namespace' => true,
        'single_line_after_imports' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'if', 'foreach', 'while', 'do', 'switch', 'try'],
        ],
    ])
    ->setFinder(Finder::create()->in(__DIR__));
