<?php
namespace Stafred\Utils
{

    use App\Models\Kernel\Debug;
    use Stafred\Cache\Buffer;

    /**
     * Class Redirect
     * @package Stafred\Utils
     */
    final class Redirect
    {
        /**
         * Redirect constructor.
         */
        public function __construct()
        {

        }

        /**
         * @param string $route
         */
        public function route(string $uri)
        {
            $buffer = Buffer::input()->getAll()->routing();
            $index = array_keys(array_combine(array_keys($buffer), array_column($buffer, 'uri')), $uri);
            if(!empty($index[0]))
            {
                list($class, $method) =  explode("::", $buffer[$index[0]]["controller_method"]);
                $class = '\\App\\Controllers\\'.$class;
                (new $class())->$method();
            }
        }
    }
}


