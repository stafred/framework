<?php

namespace Stafred\Header;

use Stafred\Cache\Buffer;
use Stafred\Cache\CacheManager;
use Stafred\Kernel\TimeService;
use Stafred\Utils\Http;

/**
 * Class RequestBuilder
 * @package Stafred\Header
 */
final class RequestBuilder
{
    /**
     * RequestBuilder constructor.
     */
    public function __construct()
    {
        TimeService::start(__CLASS__);

        $this->setUrn();
        $this->setRequest();
    }

    private function setUrn()
    {
        preg_match('/^[^\\?]+/iu', rawurldecode($_SERVER['REQUEST_URI']), $match);
        Buffer::output()->request('urn', htmlentities($match[0]));
    }

    private function setRequest()
    {
        $request = [
            'resource' => [],
            'identifier' => []
        ];
        
        if(env('setting.request.enable')) {
            foreach ($_REQUEST as $key => $value){
                if(empty($value)) {
                    $request['identifier'][] = $key;
                }
                else {
                    $request['resource'][$key] = $value;
                }
            }
        }
        
        $_REQUEST = NULL;
        Buffer::output()->request('request', $request);
    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}