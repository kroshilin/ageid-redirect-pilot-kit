<?php

namespace MindGeek\Tubes\Galago\Common\Services\AgeId;


use Kroshilin\AgeId\AgeIdPayload;
use Kroshilin\AgeId\Http\AgeIdAuthNotFoundException;
use Kroshilin\AgeId\Interfaces\AgeIdResponsePersisterInterface;

class AgeIdSessionPersister implements AgeIdResponsePersisterInterface
{
    const COOKIE_NAME = "ageId";

    public function save(AgeIdPayload $ageIdPayload): void
    {
        setcookie(self::COOKIE_NAME, serialize($ageIdPayload),  time()+60*60*24*30, '/', null);
    }

    /**
     * @return AgeIdPayload
     * @throws AgeIdAuthNotFoundException
     */
    public function get(): AgeIdPayload
    {
        /** @var AgeIdPayload $payload */
        $payload = unserialize($_COOKIE[self::COOKIE_NAME] ?? '');
        if (!$payload instanceof AgeIdPayload) {
            throw new AgeIdAuthNotFoundException('No auth cookie found');
        }
        return $payload;
    }
}
