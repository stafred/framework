<?php

namespace Stafred\Header;

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
        //$this->setHeader("X-Powered-By", $by);
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
     * @return string
     */
    private function setCharset(): string
    {
        return ';charset=' . HEADERS_DEFAULT_CHAR;
    }
}