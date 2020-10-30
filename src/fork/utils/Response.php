<?php

namespace Stafred\Utils;

use Stafred\Kernel\AppShutdown;

/**
 * Class Response
 * @package Stafred\Utils
 */
final class Response
{

    /**
     * @var
     */
    private static $response;

    /**
     * @param int $code
     */
    public static function error(int $code = 500, string $statusTest = '')
    {
        Header::make()->setStatus($code);
        if(!empty($statusTest))
        {
            Header::make()->setStatusText($statusTest);
        }
        new AppShutdown();
        throw new \Exception($statusTest, $code);
        die;
    }


    /**
     * @param array $array
     * @param bool $contentType
     * @return Response
     */
    public static function json(array $array, bool $contentType = true): Response
    {
        self::$response = json_encode($array);

        if($contentType){
            Header::make()->setHeader('Content-Type','application/json');
        }

        return new self();
    }

    /**
     * @param int $statusCode
     * @param string $statusText
     * @return Response
     */
    public function setHeader(int $statusCode = 200, string $statusText = ''): Response
    {
        $header = Header::make();

        $header->setStatus($statusCode);
        $header->setStatusText($statusText);

        return new self();
    }

    /**
     * echo string
     */
    public function echo(): void
    {
        echo self::$response;
    }

    /**
     * @return string
     */
    public function return(): string
    {
        return self::$response;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return self::$response;
    }
}