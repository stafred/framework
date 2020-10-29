<?php

namespace Stafred\Cache;

/**
 * Class Buffer
 * @package Stafred\Cache
 */
final class Buffer
{
    /**
     * @return BufferOutput
     */
    public static function output(): BufferOutput
    {
        return new class extends BufferOutput {
            /**
             * @param string $method
             * @param string $key
             * @param $value
             */
            protected function run(string $method, string $key, $value)
            {
                CacheStorage::put($method, $key, $value);
            }

            /**
             * @return BufferForce
             */
            public function putAll() : BufferForce
            {
                return new class extends BufferForce
                {
                    /**
                     * @param string $method
                     * @param string $key
                     * @param $value
                     */
                    protected function run(string $method, $value)
                    {
                        CacheStorage::putAll($method, $value);
                    }
                };
            }
        };
    }

    /**
     * @return BufferInput
     */
    public static function input(): BufferInput
    {
        return new class extends BufferInput {
            /**
             * @param string $method
             * @param string $key
             * @param $value
             */
            protected function run(string $method, string $key)
            {
                return CacheStorage::get($method, $key);
            }

            /**
             * @param string $method
             * @param string $key
             * @return bool
             */
            protected function key(string $method, string $key): bool
            {
                return CacheStorage::isKey($method, $key);
            }

            /**
             * @return BufferPull
             */
            public function getAll(): BufferPull
            {
                return new class extends BufferPull {
                    /**
                     * @param string $method
                     * @return array
                     */
                    protected function run(string $method): array
                    {
                        return CacheStorage::getAll($method);
                    }
                };
            }
        };
    }
}