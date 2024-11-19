<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = Finder::create()
    ->exclude(['.github', 'bin', 'git-hooks'])
    ->in(__DIR__);
$config = new Config();

return (new Config())
    ->setFinder($finder)
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@PER-CS' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
