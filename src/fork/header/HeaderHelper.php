<?php

namespace Stafred\Header;

/**
 * Class HeaderHelper
 * @package Stafred\Header
 */
class HeaderHelper extends CorsManager
{
    final public function makeContentType()
    {
        switch($this->contentType) {
            case NULL:
                $type = ContentType::HTML . $this->setCharset();
                break;
            case ContentType::HTML:
                $type = ContentType::HTML . $this->setCharset();
                break;
            default:
                $type = $this->contentType;
        }
        header('Content-Type: ' . $type);
    }

    final public function setPowerBy()
    {
        $by = (empty(HEADERS_POWERED_BY))
            ? "unknown"
            : HEADERS_POWERED_BY
        ;
        header("X-Powered-By: " . $by);
    }

    /**
     * @return string
     */
    protected function setCharset(): string
    {
        return ';charset=' . HEADERS_DEFAULT_CHAR;
    }

    /**
     * @return bool
     */
    protected function getAccessCors(): bool
    {
        return HEADERS_CORS;
    }
}