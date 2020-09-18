<?php

namespace Stafred\Security;

/**
 * Class Encrypt
 * @package Stafred\Security
 */
final class Encrypt
{
    /**
     * @param string $input
     * @return int|string
     */
    public static function xor(string $input) {
        $key = env('app.secret.key');
        $inputLen = strlen($input);
        $keyLen = strlen($key);

        if ($inputLen <= $keyLen) {
            return $input ^ $key;
        }

        for ($i = 0; $i < $inputLen; ++$i) {
            $input[$i] = $input[$i] ^ $key[$i % $keyLen];
        }
        return $input;
    }
}