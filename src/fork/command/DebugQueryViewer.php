<?php

namespace Stafred\Command;

use Stafred\Utils\DB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DebugQueryViewer
 * @package Stafred\Command
 */
final class DebugQueryViewer extends Command
{
    protected function configure()
    {
        $this->path = dirname(__DIR__, 6) . '/bin/console';

        $this
            ->setName("query:view")
            ->addArgument("sql", InputArgument::OPTIONAL, "db query string");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $strSql = $input->getArgument('sql');

        if (empty($strSql)) {
            $output->writeln(">>> [CMD]: SQL is empty");
            return 0;
        }

        $t = microtime(true);
        $query = DB::query($strSql, [], false)->get();
        $t = microtime(true) - $t;
        $output->writeln(">>> [CMD]:  time # " . round($t, 4) . " sec.");

        if ($query->isFail()) {
            $output->writeln(">>> [CMD]: " . $query->errorInfo());
            return 0;
        }

        $all = $query->fetchAll();
        
        if($query->id() > 0) {
            $output->writeln(">>> [CMD]: ID ".$query->id());
        }

        $output->writeln(">>> [CMD]: input # " . $query->rowCount());
        
        if(count($all) < 1) {
            $output->writeln($query->id());
            return 0;
        }

        foreach ($all as $key => $row) {
            $elem = 0;
            $output->writeln("row({$key}):\n[\t");
            $str = "";
            foreach ($row as $k => $v) {
                $str .= "'{$k}' => '{$v}', ";
                if ($elem % 3 == 2) {
                    $output->writeln("\t".$str);
                    $str = "";
                }
                $elem++;
            }
            $output->writeln("]");

        }

        return 0;
    }
}