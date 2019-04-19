<?php

namespace MindGeek\Tubes\Galago\Common\Services\AgeId;


class AgeIdSessionPersister implements AgeIdResponsePersisterInterface
{
    const COOKIE_NAME = "ageId";

    public function save(AgeIdPayload $ageIdPayload): void
    {
        \LibFE_Cookie::setSecuredCookie(self::COOKIE_NAME ,serialize($ageIdPayload));
    }

    /**
     * @return AgeIdPayload
     * @throws AgeIdAuthNotFoundException
     */
    public function get(): AgeIdPayload
    {
        /** @var AgeIdPayload $payload */
        $payload = unserialize(\LibFE_Cookie::getSecuredCookie(self::COOKIE_NAME));
        if (!$payload) {
            throw new AgeIdAuthNotFoundException('No auth cookie found');
        }
        return $payload;
   }
}
