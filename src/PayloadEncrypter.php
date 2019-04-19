<?php

namespace Kroshilin\AgeId;

use AgeId\EncryptionHelper;

class PayloadEncrypter
{
    /** @var string */
    protected $ageIdVersion;
    /** @var string */
    protected $key;
    /** @var string */
    protected $cipher;

    /**
     * Create a new encrypter instance.
     *
     * @param string $key
     * @param string $cipher
     * @param string $ageIdVersion
     */
    public function __construct(string $key, string $cipher = 'AES-256-CBC', string $ageIdVersion = 'v2')
    {
        $this->cipher = $cipher;
        $this->key = $key;
        $this->ageIdVersion = $ageIdVersion;
    }

    /**
     * Encrypt the given value.
     *
     * @param  array $value
     *
     * @return string
     * @throws \AgeId\AgeIdException
     */
    public function encrypt(array $value): string
    {
        $encrypter = new EncryptionHelper($this->key, null, $this->ageIdVersion);
        $value = \GuzzleHttp\json_encode($value);
        $encrypted = $encrypter->encrypt($value);
        return $encrypted;
    }

    /**
     * Decrypt the given value.
     *
     * @param  string $payload
     *
     * @return mixed
     * @throws \AgeId\AgeIdException
     */
    public function decrypt($payload)
    {
        $decrypter = new EncryptionHelper($this->key, null, $this->ageIdVersion);
        $decrypted = $decrypter->decrypt($payload);
        return \GuzzleHttp\json_decode($decrypted, true);
    }
}