<?php

namespace Stafred\Command;

use Stafred\Utils\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateConsole
 * @package Stafred\Command
 */
final class CreateConsole extends Command
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
            ->setName("create:console")
            ->addArgument("console", InputArgument::REQUIRED)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!$this->consoleExists()){
            $output->write(">>>\t[error]: directory \"bin/console\" is missing");
            return;
        }

        $this->setCommand($input->getArgument('console'));

        if($this->commandExists()){
            $output->write(">>>\t[error]: console command already exists");
            return;
        }

        $this->createCommand();
        $output->write(">>>\t[status]: command created\n\r");
    }

    /**
     * @return bool
     */
    private function consoleExists()
    {
        return file_exists($this->path);
    }

    /**
     * @param string $command
     */
    private function setCommand(string $command)
    {
        $this->command = Str::reverseSlash($command);
        $this->setClass($command);
    }

    /**
     * @return bool
     */
    private function commandExists()
    {
        return file_exists($this->path.'/'.$this->command.'.php');
    }

    private function createCommand()
    {
        file_put_contents($this->path . '/' . $this->command . '.php', $this->getData());
    }

    /**
     * @param string $class
     */
    private function setClass(string $class)
    {
        $this->class = $class;
    }

    /**
     * @param string $dir
     */
    private function setNamespace(string $dir)
    {
        if(!empty($dir))
        {
            $this->namespace .= '\\'.$dir;
        }
    }

    /**
     * @return string
     */
    private function getData()
    {
        return <<<HEREDATA
        <?php  
        namespace {$this->namespace};\n
        use Symfony\Component\Console\Command\Command;
        use Symfony\Component\Console\Input\InputArgument;
        use Symfony\Component\Console\Input\InputInterface;
        use Symfony\Component\Console\Output\OutputInterface;
        /**
         * Class {$this->class}
         * @package {$this->namespace}
         */
        class {$this->class} extends Command {
        
            /**
             *
             */
            protected function configure()
            {
                \$this
                    ->setName("your_name@your_task:your_execute")
                    ->addArgument("your_arg", InputArgument::REQUIRED)
                ;
            }
            
            /**
             * @param InputInterface \$input
             * @param OutputInterface \$output
             * @return int|void
             */
            protected function execute(InputInterface \$input, OutputInterface \$output)
            {
                \$output->write(">>>\t[status]: new text\\n\\r");
            }
        }
        HEREDATA;
    }

}