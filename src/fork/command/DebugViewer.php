<?php


namespace Stafred\Command;


use Stafred\Utils\Json;
use Stafred\Utils\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DebugViewer  extends Command
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $command;
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $namespace = 'Bin\\Console';

    /**
     *
     */
    protected function configure()
    {
        $this->path = dirname(__DIR__,6).'/bin/console';

        $this
            ->setName("debug:view")
            ->addArgument("console", InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $log = dirname("../", 4) . "/public/debug.log";

        if(file_exists($log)){
            $output->write(">>> [DEBUG] PUBLIC LOG\n\r");
            dumper(Json::decode(file_get_contents($log),true));

        }
        else {
            $output->write(">>> [DEBUG] PUBLIC LOG not found\n\r");
        }
        
        $log = dirname("../", 4) . "/async/debug.log";
        
        if(file_exists($log)){
            $output->write(">>> [DEBUG] ASYNC LOG\n\r");
            dumper(Json::decode(file_get_contents($log),true));
        }
        else {
            $output->write(">>> [DEBUG] ASYNC LOG not found\n\r");
        }
    }
}