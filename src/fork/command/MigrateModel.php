<?php

namespace Stafred\Command;

use Stafred\Utils\DB;
use Stafred\Utils\Env;
use Stafred\Utils\Json;
use Stafred\Utils\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateFieldsModel
 * @package Stafred\Command
 */
class MigrateModel extends Command
{
    /**
     * @var string
     */
    private $path;

    protected function configure()
    {
        $this->path = Str::reverseSlash(dirname(__DIR__,1) . '/model/');

        $this
            ->setName("migrate:model-deprecate");
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tables = DB::query("SELECT TABLE_NAME as `table`, COLUMN_NAME as `column`
            FROM  INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ?", ['status'])->get();
        $methods = [];
        foreach($tables->fetchAll() as $elem){
            $methods[$elem["table"]] = "\tfinal public function {$elem["table"]}(){\n\t\treturn new ModelBuilder(__FUNCTION__);\n\t}\n";
        }

        file_put_contents($this->path . "/ModelFields.php", $this->template(
            implode("\n", $methods)
        ));
    }

    private function template(string $methods)
    {
return <<<HEREDOC
<?php

namespace Stafred\Model;

abstract class ModelFields
{
{$methods}
}
HEREDOC;
    }
}