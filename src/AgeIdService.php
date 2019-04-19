<?php

namespace Kroshilin\AgeId;

use Carbon\Carbon;
use Kroshilin\AgeId\Interfaces\AgeIdResponsePersisterInterface;

class AgeIdService
{
    private $config;
    private $encrypter;
    private $persister;

    public function __construct(AgeIdConfig $config, PayloadEncrypter $encrypter, AgeIdResponsePersisterInterface $persister)
    {
        $this->config = $config;
        $this->encrypter = $encrypter;
        $this->persister = $persister;
    }

    /**
     * @return AgeIdConfig
     */
    public function getConfig(): AgeIdConfig
    {
        return $this->config;
    }

    /**
     * @param AgeIdPayload $payload
     * @return bool
     */
    public function isAgeIdPayloadValid(AgeIdPayload $payload): bool
    {
        if ($payload->getStatus() === AgeIdPayload::STATUS_VERIFIED) {
            return true;
        }

        return false;
    }

    /**
     * @param string $redirectToAfterVerification
     * @return string
     * @throws \AgeId\AgeIdException
     */
    public function getRedirectUrlToAgeId(string $redirectToAfterVerification): string
    {
        $payloadData = $this->encrypter->encrypt([
            'expires_at' => Carbon::now()->addMinutes($this->config->timeout)->format('Y-m-d H:i:s'),
            'redirect_uri' => $redirectToAfterVerification
        ]);

        return $this->config->ageIdApiBaseUrl . '/sso/v2/handshake?pilot=redirect&client_id='
            . $this->config->clientId . '&payload=' . urlencode($payloadData);
    }

    /**
     * @return AgeIdResponsePersisterInterface
     */
    public function getPersister(): AgeIdResponsePersisterInterface
    {
        return $this->persister;
    }

    /**
     * @return PayloadEncrypter
     */
    public function getEncrypter(): PayloadEncrypter
    {
        return $this->encrypter;
    }
}