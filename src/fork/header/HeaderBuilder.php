<?php

namespace Stafred\Header;

/**
 * Class Header
 * @package Stafred\Header
 */
final class HeaderBuilder extends HeaderHelper
{
    /**
     * @var string|NULL
     */
    protected $contentType = NULL;

    /**
     * Header constructor.
     * @param string|NULL $contentType
     * @param bool $change
     */
    public function __construct(string $contentType = NULL, bool $change = false)
    {
        $this->contentType = $contentType;
        if (!$change) {
            $this->makeContentType();
        }
        $this->setPowerBy();

    }
}