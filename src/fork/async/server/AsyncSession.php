<?php

namespace Stafred\Async\Server;

use Stafred\Utils\Arr;
use Stafred\Utils\Http;
use Stafred\Utils\Json;

/**
 * Class AsyncSession
 * @package Stafred\Async\Server
 */
final class AsyncSession
{
    /**
     * @var string
     */
    protected string $id;
    /**
     * @var string
     */
    protected string $pathSession = '../factory/session/';
    /**
     * @var string
     */
    const PATH_STORAGE = '../factory/storage/async/';

    /**
     * AsyncSession constructor.
     */
    public function __construct()
    {
        $this->clearStorage();
    }


    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function missing(): bool
    {
        return !file_exists($this->pathSession . 'sess_' . $this->getId());
    }

    public function clearStorage()
    {
        $scan = Arr::cutValue(
            ['.','..','.keep'],
            scandir(self::PATH_STORAGE),
            true
        );
        if(!Arr::isKey(0, $scan)){
            return;
        }
        $filepath = self::PATH_STORAGE . $scan[0];
        if(!file_exists($filepath)){
            return;
        }
        if(filectime($filepath) + 5 * 60 < microtime(true)){
            unlink($filepath);
        }
    }

    /**
     * @param string $token
     */
    public function failToken()
    {
        $str = explode("&token=", Http::getQueryString());
        $request  = $str[0];
        $token  = $str[1];
        $session = Json::decode(file_get_contents($this->pathSession . 'sess_' . $this->getId()));
        return md5($request.$session->_name) !== $token;
    }
}