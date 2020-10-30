<?php

namespace Stafred\Async\Client;

use Stafred\Async\Server\AsyncServer;
use Stafred\Async\Server\Request;
use Stafred\Utils\Json;

/**
 * Class AsyncHelper
 * @package Stafred\Async\Client
 */
abstract class AsyncHelper implements AsyncClient, AsyncServer
{

    const HEADER = 'GET / HTTP/1.1\r\n';
    const PROTOCOL = 'HTTP/1.1\r\n\r\n';

    /**
     * @var
     */
    protected $host;
    /**
     * @var
     */
    protected $port;
    /**
     * @var
     */
    protected $setsdn;
    /**
     * @var string
     */
    protected string $connect;
    /**
     * @var string
     */
    protected string $dir;
    /**
     * @var string
     */
    protected string $route;
    /**
     * @var string
     */
    protected string $sessionId;
    /**
     * @var string
     */
    protected string $request;
    /**
     * @var bool
     */
    protected bool $error = false;
    /**
     * @var false|string|null
     */
    protected $async;
    /**
     * @var string
     */
    protected string $pure = '';

    /**
     * @param string $controller_method
     */
    final public function action(string $route)
    {
        $this->route = $route;
    }

    /**
     * @param array $identifiers
     */
    final public function request(array $identifiers): void
    {
        $request = [];
        foreach ($identifiers as $k=>$v){
            $request[] = $k . '=' . $v;
        }
        $this->request = implode("&", $request);
    }

    /**
     * @param string $sessionId
     */
    final public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    final public function getSessionId(): string
    {
        return $this->sessionId;
    }


    public function connect()
    {
        $this->ssc = stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $this->errno, $this->errstr, 0.005,
            STREAM_CLIENT_CONNECT
        );

        return $this->ssc;
    }

    /**
     * stream ~ signal ~ async ~ write
     */
    public function run(bool $read = false)
    {
        if($this->shutdown()) return NULL;
        $connect = $this->connect();

        if (!$connect) {
            $this->disconnect();
            return NULL;
        }

        $message = "?async=" . $this->message;

        fwrite($connect, "".
            "GET /$message HTTP/1.1\r\n".
            "Host: {$this->host}:{$this->port}\r\n".
            "Accept: application/json\r\n\r\n"
        );

        if($read === true) {
            $read = fgets($connect, 1024);
            $this->close($read);
            return $read;
        }
        else {
            $this->close();
            return NULL;
        }
    }

    public function disconnect(): void
    {
        file_put_contents($this->dir . $this->shutdown, "");
        $this->error = true;
    }

    public function start(): void
    {
        // TODO: Implement start() method.
    }

    /**
     * @return bool
     */
    public function shutdown()
    {
        if (file_exists($this->dir . $this->setsdn)) {
            $this->error = true;
            return true;
        }
        return false;
    }

    public function close()
    {
        fclose($this->ssc);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->async);
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return json_decode($this->get(), true);
    }

    /**
     * @return false|string|null
     */
    public function get()
    {
        return $this->async;
    }

    /**
     * @return string
     */
    public function pure(): string
    {
        return $this->pure;
    }

    /**
     * @param Request $request
     */
    public function bindRequest(Request $request)
    {
        $this->resuest = $request;
    }

    abstract public function server();
    abstract public function client();
}