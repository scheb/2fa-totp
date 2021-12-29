<?php

declare(strict_types=1);

namespace Scheb\TwoFactorBundle\Model\Totp;

use InvalidArgumentException;
use function in_array;
use function sprintf;

class TotpConfiguration implements TotpConfigurationInterface
{
    public const ALGORITHM_MD5 = 'md5';
    public const ALGORITHM_SHA1 = 'sha1';
    public const ALGORITHM_SHA256 = 'sha256';
    public const ALGORITHM_SHA512 = 'sha512';

    private string $algorithm;

    /**
     * @param string $secret    Base32 encoded secret key
     * @param string $algorithm Hashing algorithm to be used, see class constants for available values
     * @param int    $period    Period in seconds, when the one-time password changes
     * @param int    $digits    Number of digits of the one-time password
     */
    public function __construct(
        private string $secret,
        string $algorithm,
        private int $period,
        private int $digits,
    ) {
        if (!self::isValidAlgorithm($algorithm)) {
            throw new InvalidArgumentException(sprintf('The algorithm "%s" is not supported', $algorithm));
        }

        $this->algorithm = $algorithm;
    }

    private static function isValidAlgorithm(string $algorithm): bool
    {
        return in_array(
            $algorithm,
            [
                self::ALGORITHM_MD5,
                self::ALGORITHM_SHA1,
                self::ALGORITHM_SHA256,
                self::ALGORITHM_SHA512,
            ],
            true
        );
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    public function getDigits(): int
    {
        return $this->digits;
    }
}
