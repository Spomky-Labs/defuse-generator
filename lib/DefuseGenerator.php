<?php

namespace Security;

/*
 * Unbiased random password generator.
 * This code is placed into the public domain by Defuse Security.
 * WWW: https://defuse.ca/
 * Modified by Florent Morselli to fit on the project and coding standard
 */
class DefuseGenerator
{
    /**
     * Create a random string composed of a characters.
     * $length - The number of random strings to include in the result.
     *
     * @param int    $length
     * @param string $charset
     *
     * @throws \InvalidArgumentException If the charset is invalid or if the length is less than 1.
     *
     * @return string
     */
    public static function getRandomString($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~+/')
    {
        self::checkLength($length);
        $charset = count_chars($charset, 3);
        self::checkCharset($charset);
        $characterSet = str_split($charset);
        $charSetLen = count($characterSet);

        $random = self::getRandomInts($length * 2);
        $mask = self::getMinimalBitMask($charSetLen - 1);

        $password = '';

        $iterLimit = max($length, $length * 64); // If length is close to PHP_INT_MAX we don't want to overflow.
        $randIdx = 0;
        while (self::safeStringLength($password) < $length) {
            if ($randIdx >= count($random)) {
                $random = self::getRandomInts(2 * ($length - self::safeStringLength($password)));
                $randIdx = 0;
            }

            // This is wasteful, but RNGs are fast and doing otherwise adds complexity and bias.
            $c = $random[$randIdx++] & $mask;
            // Only use the random number if it is in range, otherwise try another (next iteration).
            if ($c < $charSetLen) {
                $password .= self::sideChannelSafeArrayIndex($characterSet, $c);
            }

            // Guarantee termination
            $iterLimit--;
            if ($iterLimit <= 0) {
                throw new \RuntimeException('Hit iteration limit when generating password.');
            }
        }

        return $password;
    }

    /**
     * Returns the character at index $index in $string in constant time.
     *
     * @param string[] $string
     * @param int      $index
     *
     * @return bool|string
     */
    private static function sideChannelSafeArrayIndex($string, $index)
    {
        $nb = count($string);
        if ($nb > 65535 || $index > $nb) {
            return false;
        }
        $character = 0;
        for ($i = 0; $i < $nb; $i++) {
            $x = $i ^ $index;
            $mask = (((($x | ($x >> 16)) & 0xFFFF) + 0xFFFF) >> 16) - 1;
            $character |= ord($string[$i]) & $mask;
        }

        return chr($character);
    }

    /**
     * Returns the smallest bit mask of all 1s such that ($toRepresent & mask) = $toRepresent.
     * $toRepresent must be an integer greater than or equal to 1.
     *
     * @param int $toRepresent
     *
     * @return int
     */
    private static function getMinimalBitMask($toRepresent)
    {
        $mask = 0x1;
        while ($mask < $toRepresent) {
            $mask = ($mask << 1) | 1;
        }

        return $mask;
    }

    /**
     * Returns an array of $numInts random integers between 0 and PHP_INT_MAX.
     *
     * @param int $numInts
     *
     * @return integer[]
     */
    private static function getRandomInts($numInts)
    {
        $ints = [];
        $rawBinary = mcrypt_create_iv($numInts * PHP_INT_SIZE, MCRYPT_DEV_URANDOM);
        for ($i = 0; $i < $numInts; ++$i) {
            $thisInt = 0;
            for ($j = 0; $j < PHP_INT_SIZE; ++$j) {
                $thisInt = ($thisInt << 8) | (ord($rawBinary[$i * PHP_INT_SIZE + $j]) & 0xFF);
            }
            // Absolute value in two's compliment (with min int going to zero)
            $thisInt = $thisInt & PHP_INT_MAX;
            $ints[] = $thisInt;
        }

        return $ints;
    }

    /**
     * Get the length of the string.
     *
     * @param string $str The string
     *
     * @return int The length of the string
     */
    private static function safeStringLength($str)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, '8bit');
        }

        return strlen($str);
    }

    /**
     * Checks if the length of the resulting random string is valid or not.
     *
     * @param int $length The length of the random string
     */
    private static function checkLength($length)
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Invalid length. Must be greater than 0.');
        }
    }

    /**
     * Checks if the charset is valid or not.
     *
     * @param string $charset The charset
     */
    private static function checkCharset($charset)
    {
        if (!is_string($charset) || self::safeStringLength($charset) < 2) {
            throw new \InvalidArgumentException('Invalid charset. Must contain at least two characters.');
        }
    }
}
