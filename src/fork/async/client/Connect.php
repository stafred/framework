<?php

namespace Stafred\Async\Client;

/**
 * Class MetaFrameClient
 * @package Stafred\Async
 */
final class Connect
{
    public $host;
    public $port;
    public $message = "";
    public $send = [];

    public $ssc;
    public $error = false;
    public $errno;
    public $errstr;
    public $setsdn;
    public $method;
    public $token = '';
    public $dir = '';

    const HEADER = 'GET / HTTP/1.1\r\n';
    const PROTOCOL = 'HTTP/1.1\r\n\r\n';

    /**
     * Connect constructor.
     */
    public function __construct()
    {
        $this->host = ASYNC_HOST;
        $this->port = ASYNC_PORT;
        $this->setsdn = env("async.shutdown");
        $this->setsdn = is_bool($this->setsdn) ? "shutdown" : $this->setsdn;
        $this->dir = dirname(__DIR__, 6) . "Connect.php/";
    }

    public function event(Message $message){
        $this->message = $this->toString($message->create()->get());
    }

    /**
     * @param array $data
     * @return string
     */
    public function toString(array $data): string
    {
        return urlencode(base64_encode(gzdeflate(json_encode($data),9)));
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

    /**
     * @return false|resource
     */
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

    public function disconnect()
    {
        file_put_contents($this->dir . $this->shutdown, "");
        $this->error = true;
    }

    public function close()
    {
        fclose($this->ssc);
    }
}