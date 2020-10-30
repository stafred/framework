<?php

namespace Stafred\Kernel;

use Stafred\Utils\Env;
use Stafred\Utils\Str;
use Symfony\Component\Console\Application;


/**
 * Class Console
 * @package Status\System
 */
final class Console
{
    /**
     * @var bool
     */
    private static $run = false;
    /**
     * @var string
     */
    private static $namespace = 'Stafred\\Command\\';
    private static $namespaceBin = 'Bin\\Console\\';
    /**
     * @var bool
     */
    private static $path = '/../command/';
    private static $pathBin = '/bin/console/';

    /**
     * @throws \Exception
     */
    public static function run()
    {
        /**
         *  убрать костыль и перенести в бутстрап запуска
         */
        Env::get();
        $enable = env('app.terminal.enable');
        if ($enable) {
            self::check();
            self::find();
            self::application();
        }
    }

    /**
     * @throws \Exception
     */
    private static function check()
    {
        if (self::$run) {
            throw new \Exception("console class has already been started");
        }

        self::$run = true;
    }

    /**
     * @throws \Exception
     */
    private static function application()
    {
        $app = new Application();

        foreach (self::find() as $key => $value) {
            $value = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);

            if (!class_exists($value))
                throw new \Exception("class for task execution not found");

            $app->add(new $value);
        }

        $app->run();
    }

    /**
     * @return array
     * @throws \Exception
     */
    private static function find()
    {
        $pathCom = __DIR__ . self::$path;
        $pathBin = Str::reverseSlash(
            dirname(__DIR__, 6) . self::$pathBin
        );
        $loopScan = function ($namespace) use (&$scan, &$result) {
            foreach ($scan as $key => $value) {
                $result[] = $namespace . $value;
            }
            return $result;
        };

        if (!file_exists($pathCom) or !file_exists($pathBin))
            throw new \Exception("directories not found");

        $result = [];

        $scan = array_diff(scandir($pathCom), ['.', '..']);
        $result = $loopScan(self::$namespace);

        $scan = array_diff(scandir($pathBin), ['.', '..', '.keep']);
        $result = $loopScan(self::$namespaceBin);

        return array_unique($result);
    }

    /**
     * @const start
     * @const error
     * @const close
     * @return (object) [start : string, error : string, close : string]
     */
    public static function info()
    {
        return (object)[
            "start" => "\n>>> [Stafred] Terminal @ " . date("Y") . "\n",
            "error" => "\n>>> [Stafred] Terminal (Error: autoload.php not found)\n",
            "close" => "\n>>> [Stafred] Terminal close\n",
        ];
    }
}
