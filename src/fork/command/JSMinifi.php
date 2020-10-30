<?php

namespace Stafred\Command;

/**
 *
 */
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class JSMinifi
 * @package Stafred\Command
 */
final class JSMinifi extends Command
{
    protected function configure()
    {
        $this
            ->setName("js:minify")
            ->addArgument("filename", InputArgument::REQUIRED)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pathJs = path()->root()->public() . '/js/';
        $file = $pathJs . $input->getArgument('filename');

        if(!file_exists($file)){
            $output->writeln(">>> [CMD]: file not found...");
            return 0;
        }

        $fileText = file_get_contents($file);
        $fileNameMinify = preg_replace("/\.js$/i", ".min.js", $file);

        $patterns = [
            ["/\s+\/\/.+/",         ""],
            ["/\t*|\r\n|\n*/",       ""],
            ["/\s*\(/",             "("],
            ["/\)\s*/",             ")"],
            ["/\s*\{\s*/",          "{"],
            ["/\s*\}\s*/",           "}"],
            ["/\t*\{\t*/",          "{"],
            ["/\t*\}\t*/",          "}"],
            ["/\s*=\s*/",           "="],
            ["/\s*;\s*/",           ";"],
            ["/function\s*\(/",     "function("],
            ["/\s*=\>\s*/",         "=>"],
            ["/\s{2,}&&\s{2,}/",    " && "],
            ["/if\s*\(\s*/",        "if("],
            ["/else if\s*\(\s*/",   "else if("],
            ["/\s{3,}/",            ""],
            ["/\s*&&\s*/",          "&&"],
            ["/\s*\|\|\s*/",        "||"],
        ];

        foreach ($patterns as $pattern) {
            $fileText = preg_replace($pattern[0], $pattern[1], $fileText);
        }

        file_put_contents($fileNameMinify, $fileText);
        $output->writeln(">>> [CMD]: compression was successful.");
        return 0;
    }
}