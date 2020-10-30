<?php

namespace Stafred\Async;

use Stafred\Utils\Session;

/**
 * Class Helper
 * @package Stafred\Async
 */
abstract class Helper implements Client
{
    /**
     * @var string
     */
    protected string $session = '';
    /**
     * @var string
     */
    protected string $token = '';
    /**
     * @var string
     */
    protected string $url = '';
    /**
     * @var string
     */
    protected string $request = '';
    /**
     * @var string
     */
    protected string $data = '';
    /**
     * @var false|resource
     */
    protected $ssc;
    /**
     * @var bool
     */
    protected $error = false;
    /**
     * @var
     */
    protected $errno;
    /**
     * @var
     */
    protected $errstr;
    /**
     * @var string
     */
    protected string $dir = '';
    /**
     * @return Client
     */
    abstract public function client(): Client;

    /**
     * @return Server
     */
    abstract public function server(): Server;

    /**
     * @param string $url
     * @param array $data
     */
    final public function route(string $url, array $data): void
    {
        $this->url = $url;
        $request = [];
        foreach ($data as $k=>$v) {
            $request[] = $k . "=" . $v;
        }
        $this->request = implode("&", $request);
    }

    /**
     * @param array $data
     */
    final public function header(array $data): void
    {

    }

    /**
     * @param bool $read
     */
    final public function run(bool $read = false): void
    {
        if($this->shutdown()) return;
        $connect = $this->connect();

        if (!$connect) {
            $this->disconnect();
            return;
        }

        $message =
            "session=".$this->session . "&" .
            $this->request
        ;

        $this->token = md5($message . Session::get("_name") . $this->data);
        $message .= "&token=" . $this->token;


        fwrite($connect, "".
            "GET {$this->url}?{$message} HTTP/1.1\r\n".
            "Host: {$this->host}:{$this->port}\r\n".
            "Data: {$this->data}\r\n".
            "Accept: application/json\r\n\r\n"
        );

        if($read === true) {
            $read = fgets($connect, 128);
        }
    }

    /**
     * @return false|resource
     */
    protected function connect()
    {
        $this->ssc = stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $this->errno, $this->errstr, 0.005,
            STREAM_CLIENT_CONNECT
        );

        return $this->ssc;
    }

    /**
     * @return bool
     */
    final public function shutdown(): bool
    {
        if (file_exists($this->dir . $this->setsdn)) {
            return $this->error = true;
        }
        return false;
    }

    final public function close(): void
    {
        //fclose($this->ssc);
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }
}