<?php

namespace Kroshilin\AgeId;


class AgeIdPayload
{
    const STATUS_VERIFIED = 'verified';
    const STATUS_UNVERIFIED = 'unverified';

    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}