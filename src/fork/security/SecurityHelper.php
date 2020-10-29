<?php

namespace Stafred\Security;

use Stafred\Utils\Arr;
use Stafred\Utils\Http;

class SecurityHelper
{
    /**
     * @var array
     */
    protected $methods = [];

    /**
     * SecurityHelper constructor.
     */
    public function __construct()
    {
        $this->methods = get_class_methods($this);
        unset($this->methods[0]);
    }

    /**
     * @throws \Stafred\Exception\SessionNameNotDefinedException
     */
    protected function sessionSetName(): void
    {
        $session = env("SESSION_HEADER_NAME");

        if (!$session) {
            throw new \Stafred\Exception\SessionNameNotDefinedException();
        }
    }

    /**
     * @throws \Stafred\Exception\SessionProtocolErrorException
     */
    protected function sessionHttpProtocol(): void
    {
        $secure = Http::isSecurity();
        $https = env("SESSION_HTTPS_ENABLE");

        if ($https === true && $secure === false) {
            throw new \Stafred\Exception\SessionProtocolErrorException();
        }
    }

    protected function sessionClearOlder()
    {
        if(Http::isAjax()) return;
        $time = env('SESSION_FILE_LIFETIME');
        $dir  = env('SESSION_FILE_DIRPATH');
    }
}