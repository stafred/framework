<?php

namespace Stafred\View;

use Stafred\Cache\Buffer;
use Stafred\Metastream\UDPClient;

/**
 * Class ViewWrapper
 * @package Stafred\View
 */
final class ViewWrapper extends ViewAbstract
{
    /**
     * @param String $viewName
     * @return View|null
     * @throws \Exception
     */
    public static function make(string $name)
    {
        if (empty($name)) {
            throw new \Exception('views name missing'/*, 500*/);
        }

        self::$viewName = preg_replace("/\.|\\|\_|\-/", '/', $name);
        self::$inst = new self;
        return self::$inst;
    }

    /**
     * @return String|NULL
     * @throws \Exception
     */
    public function return(): string
    {
        $content = self::getContents();
        //$content .= '<script src="../js/base64.js"></script>';
        //$content .= '<script src="../js/rawdeflate.js"></script>';
        //$content .= '<script src="../js/rawinflate.js"></script>';
        return $content ;
    }

    /**
     * @throws \Exception
     */
    public function echo(): void
    {
        echo self::getContents();
    }

    /**
     * @return ViewAbstract
     */
    public function stream()
    {
        $client = Buffer::input()->general('metastream');
        $client->send(
            $client->getToken(),
            'content',
            self::$viewName
        );

        $stream = new class extends ViewAbstract
        {
            public function echo()
            {
                echo self::getStreamContents(self::$streamContent);
            }

            /**
             * @return String
             */
            public function return()
            {
                return self::getStreamContents(self::$streamContent);
            }

            /**
             * @param string $viewName
             */
            public function _set_stream_viewName(string $viewName): void
            {
                self::$viewName = $viewName;
            }

            /**
             * @param $viewName
             */
            public function _set_stream_content($content): void
            {
                self::$streamContent = $content["response"]["content"];
            }
        };

        $stream->_set_stream_viewName(self::$viewName);

        $read = $client->read();
        if(!empty($read)){
            $stream->_set_stream_content($read);
        }
        //$client->close();
        return $stream;
    }
}