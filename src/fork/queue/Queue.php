<?php

namespace Stafred\Queue;

use Stafred\Async\Cached\MemcachedConnection;
use Stafred\Queue\Await;
use Stafred\Queue\Event;
use Stafred\Queue\Remove;
use Stafred\Queue\Shutdown;
use Stafred\Queue\Signal;
use Stafred\Queue\Message;
use Stafred\Utils\Hash;

/**
 * Class Queue
 * @package Stafred\Queue
 */
final class Queue
{
    /**
     * @var array
     */
    private $execute = [];
    /**
     * @var int
     */
    private $factor = 1000;
    /**
     * @var bool
     */
    private $shutdown = false;
    /**
     * @var int
     */
    private $key = 0;
    /**
     * @var Event
     */
    private $event;
    /**
     * @var Message
     */
    private $message;
    /**
     * @var Signal
     */
    private $signal;
    /**
     * @var int|float
     */
    private $time = 0.1;
    /**
     * @var \Memcached
     */
    private $buffer;
    /**
     * @var string
     */
    private $token;
    /**
     * Queue constructor.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
        $this->event = new Event();
        $this->message = new Message();
        $this->signal = new Signal();
        $this->buffer = (new MemcachedConnection())->get();
    }

    /**
     * @param int $key
     */
    public function bind(int $key = 0)
    {
        $this->key = $key;
    }

    /**
     * @param callable $execute
     * @return $this
     */
    public function exec(callable $execute)
    {
        $this->execute[$this->key] = $execute;
        $this->key++;
        return $this;
    }

    /**
     * @warning Test Method, don`t use
     * @param callable $execute
     * @return $this
     */
    public function execTimeout(callable $execute, int $sec, int $msec, int $reduce = 1000)
    {
        return $this;
    }

    /**
     * @param int $sec
     * @param int $msec
     * @param int $reduce
     * @return $this
     */
    public function setTimeout(int $sec, int $msec, int $reduce = 1000)
    {
        $this->time = $this->timeCalc($sec, $msec, $reduce);
        return $this;
    }

    public function run()
    {
        $time = microtime(true) + $this->time;

        while (true) {
            if ($time <= microtime(true) || $this->shutdown) {
                break;
            }

            $key = key($this->execute);

            if (count($this->execute) >= 1) {
                if (next($this->execute) === false || empty($this->execute[$key])) {
                    reset($this->execute);
                }
            } else {
                break;
            }

            if (is_callable($this->execute[$key])) {
                $result = $this->execute[$key](
                    $this->event, $this->message, $this->buffer, $key
                );
            }


            if ($result instanceof Await) {
                if (count($this->execute) == 1) {
                    break;
                }
                continue;
            } elseif ($result instanceof Signal) {
                if (count($this->execute) <= 1) {
                    $this->execute = [];
                    break;
                }
                $this->message = new Message();
                $this->message->set($result->get());
            } elseif ($result instanceof Shutdown) {
                $this->shutdown = true;
            } elseif ($result instanceof Message) {
                $this->message = $result;
            } elseif ($result instanceof Remove || empty($result)) {
                unset($this->execute[$key]);
            } else {
                break;
            }
        }
    }

    /**
     * @return string
     */
    private function hash()
    {
        return Hash::random("crc32");
    }

    /**
     * @param int $sec
     * @param int $msec
     * @param int $reduce
     * @return float|int
     */
    private function timeCalc(int $sec, int $msec, int $reduce = 1000)
    {
        $reduce = $reduce < 1 ? 1 : $reduce;
        $msec = $msec < 1 ? 1 : $msec;
        $msec = $msec > 1000 ? 1000 : $msec;
        $sec = $sec < 0 ? 0 : $sec;
        $sec = $sec > 30 ? 30 : $sec;
        return $sec + ($msec / $reduce);
    }
}