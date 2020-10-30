<?php
namespace Stafred\Command;

use Stafred\Utils\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateException
 * @package Stafred\Command
 */
final class CreateException extends Command
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $exception;
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $namespace = 'Bin\\Exception';

    /**
     *
     */
    protected function configure()
    {
        $this->path = dirname(__DIR__,6).'/bin/exception';

        $this
            ->setName("create:exception")
            ->addArgument("exception", InputArgument::REQUIRED)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!$this->binExists()){
            $output->write(">>>\t[error]: directory \"bin/exception\" is missing");
            return;
        }

        $this->setException($input->getArgument('exception'));

        if($this->exceptionExists()){
            $output->write(">>>\t[error]: exception already exists");
            return;
        }

        $this->createException();
        $output->write(">>>\t[status]: exception created\n\r");
    }

    /**
     * @return bool
     */
    private function binExists()
    {
        return file_exists($this->path);
    }

    /**
     * @param string $exception
     */
    private function setException(string $exception)
    {
        $this->exception = Str::reverseSlash($exception);
        $this->setClass($exception);
    }

    /**
     * @return bool
     */
    private function exceptionExists()
    {
        return file_exists($this->path.'/'.$this->exception.'.php');
    }

    private function createException()
    {
        file_put_contents($this->path . '/' . $this->exception . '.php', $this->getData());
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
        use Stafred\Exception\BaseException;
        use Stafred\Exception\ExceptionInterface;
        use Throwable;\n
        /**
         * Class {$this->class}
         * @package {$this->namespace}
         */
        class {$this->class} 
            extends BaseException
            implements ExceptionInterface
        {
            public function __construct(\$pointer = NULL)
            {
                parent::run(\$pointer);
            }
        
            public function enum(): string
            {
                return "";
            }
        
            public function debug(\$pointer = NULL): string
            {
                return "";
            }
        
            public function code(): int
            {
                return self::CODE_400;
            }
        }
        HEREDATA;
    }

}