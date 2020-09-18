<?php

namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;

/**
 * Class SessionNotFoundException
 * @package Stafred\Exception
 */
final class SessionNotFoundException extends Exception
{
    /**
     * SessionNotFoundException constructor.
     */
    public function __construct(string $path)
    {
        $header = Header::make();
        $header->setStatus(500);
        $header->setStatusText('Error session');

        parent::__construct(
            'Session file not found. It was deleted or not created. PATH: ' . $path .
            ' (Warning: remove cookies).',
            500
        );
    }
}