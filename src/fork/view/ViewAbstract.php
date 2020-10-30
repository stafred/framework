<?php

namespace Stafred\View;

use Stafred\Utils\Arr;
use Stafred\Utils\Hash;

/**
 * Class ViewAbstract
 * @package Stafred\View
 */
abstract class ViewAbstract
{
    abstract function echo();

    abstract function return();

    /**
     * @var null|View
     */
    protected static $inst = NULL;
    /**
     * @var string
     */
    protected static $viewName = '';
    /**
     * @var array
     */
    protected static $params = [];

    /**
     * @var string
     */
    protected static $streamContent = '';

    /**
     * @param array $args
     * @return ViewWrapper
     * @throws \Exception
     */
    public function params(array $args): ViewWrapper
    {
        self::check();
        if (count(self::$params) !== 0) {
            throw new \Exception('parameters already set'/*, 500*/);
        }
        self::$params = $args;
        return self::$inst;
    }

    /**
     * @param int|null $code
     * @param string $text
     * @param bool $replace
     * @return ViewWrapper
     * @throws \Exception
     */
    public function setHeader(int $code = NULL, string $text = '', bool $replace = true): ViewWrapper
    {
        self::check();
        //header('HTTP/1.1 ' . $code . ' ' . $text, $replace, $code);
        return self::$inst;
    }

    /**
     * @param int $code
     * @return ViewWrapper|null
     * @throws \Exception
     */
    public function setStatusCode(int $code): ViewWrapper
    {
        self::check();
        http_response_code($code);
        return self::$inst;
    }

    /**
     * @param String $title
     * @param String $value
     * @return ViewWrapper
     * @throws \Exception
     */
    public function setHeaderText(string $title, string $value): ViewWrapper
    {
        if (strlen($title) < 1) {
            throw new \Exception('text header is not set', 500);
        }

        header("$title: $value");

        return self::$inst;
    }

    /**
     * @throws \Exception
     */
    protected static function check(): void
    {
        if (is_null(self::$inst)) {
            throw new \Exception('required object not found', 500);
        }
    }


    /**
     * @return String
     * @throws \Exception
     */
    protected static function getContents(): string
    {
        ob_start();
        require('../app/views/' . self::$viewName . '.view.php');
        $content = ob_get_contents();
        ob_end_clean();
        return self::replacement($content);
    }

    /**
     * @return String
     * @throws \Exception
     */
    protected static function getStreamContents($content): string
    {
        return self::replacement($content);
    }

    /**
     * @param String $text
     * @return string|string[]|void|null
     * @throws \Exception
     */
    private static function replacement(string $text)
    {
        $text = self::replacementViews($text);
        $text = self::replacementVars($text);
        $text = self::replacementFuncs($text);
        $text = self::replacementExpr($text);
        return $text;
        //return base64_encode(gzdeflate($text, 9));
    }

    /**
     * нужно сделать отдельный класс
     * @param String $text
     * @return String
     */
    protected static function replacementViews(string $text)
    {
        $viewPatterns = [
            'include' => '(?=\@include\(\'([a-zA-Z0-9\-\_\.]+)\'\))'
        ];

        foreach ($viewPatterns as $key => $value) {
            preg_match_all('/' . $value . '/i', $text, $matches);
            switch ($key) {
                /*изменить*/
                case 'include':
                    $viewCache = [];
                    foreach ($matches[1] as $k => $v) {
                        if (self::$viewName == $v) {
                            throw new \Exception("the template engine detected recursive use of adding a component using the @include command. Unfortunately this procedure is not possible.");
                            return;
                        }
                        $strr = str_replace('.', '/', $v);
                        $path = dirname(__DIR__, 6) . '/app/views/' . $strr . '.view.php';
                        $path = strtolower(preg_replace("#\\\\#", "/", $path));
                        if (!file_exists($path)) {
                            throw new \Exception("File view not found [views/$strr.view.php]"/*, 500*/);
                        }
                        if (!array_key_exists($v, $viewCache)) {
                            $viewCache[$v] = file_get_contents($path);
                            $text = preg_replace('/\@include\(\'' . $v . '\'\)/', $viewCache[$v], $text);
                        }
                    }
                    break;
            }
        }

        return $text;
    }

    /**
     * @param string $text
     * @return string|string[]|null
     * @throws \Exception
     */
    private static function replacementVars(string $text)
    {
        foreach (self::$params as $k => $v) {
            $replace = '';

            if (is_string($v) or is_numeric($v) or is_null($v) or is_bool($v)) {
                $replace = $v;
            } else if (is_array($v) or is_object($v)) {
                $replace = json_encode($v);
            } else {
                throw new \Exception("Unfortunately, the specified data type is not available in the template engine [return type: " . gettype($v) . "]"/*, 500*/);
            }
            $text = preg_replace('/(\{\{\s*\\$?' . $k . '\s*\}\})/i', $replace, $text);
        }
        return $text;
    }

    /**
     * @param string $text
     * @return string|string[]|null
     * @throws \ReflectionException
     */
    protected static function replacementFuncs(string $text)
    {
        preg_match_all(
            '/{{\K(?:([\'\"])(?>\x5c.|(?!\1).)*?\1|(?!}}).)*/is',
            $text,
            $matchesFuncs
        );
        $salt = Hash::random('crc32');
        $newStringFuncs = implode('`' . $salt . '`', Arr::removeEmpty(Arr::merge($matchesFuncs)));
        preg_match_all(
            '/[_a-z]+[_a-z]*\s*\(\s*[\$a-z\d_ \,\'\"]*\s*\)/ius',
            $newStringFuncs . '',
            $matchesFuncs
        );

        $matchesFuncs = Arr::unique($matchesFuncs[0]);

        foreach ($matchesFuncs as $funcTemp) {
            $func = strstr($funcTemp, "(", true);
            $funcRefl = new \ReflectionFunction($func);
            $funcArgs = [];
            $parameters = $funcRefl->getParameters();
            //$countParameters = count($parameters);



            foreach ($parameters as $args) {
                if(!array_key_exists($args->name, self::$params)) continue;
                $funcArgs[] = self::$params[$args->name];
            }

            if(empty($funcArgs)) {
                $text = preg_replace(
                    "/\{\{\s*$func\s*\(\s*\)\s*\}\}/ius",
                    $funcRefl->invoke(),
                    $text);
            }
            else {

            }

            /*здесь доработать аргументы*/
        }
        return $text;
    }

    protected static function replacementExpr(string $text)
    {
        $pattern = "";
        return $text;
    }
}