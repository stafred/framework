<?php

namespace Stafred\Header;

use Stafred\Cache\CacheManager;

/**
 * Class HeaderHelper
 * @package Stafred\Header
 */
class HeaderHelper
{
    final public function makeContentType()
    {
        switch ($this->contentType) {
            case NULL:
                $type = ContentType::HTML . $this->setCharset();
                break;
            case ContentType::HTML:
                $type = ContentType::HTML . $this->setCharset();
                break;
            default:
                $type = $this->contentType;
        }
        //$this->setHeader("Content-Type", $type);
    }

    final public function setPowerBy()
    {
        $by = (empty(HEADERS_POWERED_BY))
            ? "unknown"
            : HEADERS_POWERED_BY;
        $this->setHeader("X-Powered-By", $by);
    }

    /**
     * @param string $key
     * @param string $value
     */
    final public function setHeader(string $key, string $value)
    {
        try {
            header("$key: " . $value);
        } catch (\Throwable $t) {}
    }

    /**
     * @param int $code
     */
    final public function setStatus(int $code, string $version = '2.0')
    {
        try {
            header("HTTP/$version $code");
        } catch (\Throwable $t) {}
    }

    /**
     * @param int $str
     */
    final public function setStatusText(string $str)
    {
        try {
            header("StatusText: $str");
        } catch (\Throwable $t) {}
    }

    final public function setCacheControl(string $control = 'public', int $max_age = 31536000){
        try {
            if($control === 'public') {
                header("Cache-Control: public, max-age=$max_age");
            }
            else {
                header("Cache-Control: $control");
            }
        } catch (\Throwable $t) {}
    }

    
    /**
     * @return string
     */
    private function setCharset(): string
    {
        return ';charset=' . HEADERS_DEFAULT_CHAR;
    }
}