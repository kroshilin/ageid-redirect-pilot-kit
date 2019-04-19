<?php

namespace Kroshilin\AgeId\Interfaces;


use Kroshilin\AgeId\AgeIdPayload;
use Kroshilin\AgeId\Http\AgeIdAuthNotFoundException;

interface AgeIdResponsePersisterInterface
{
   public function save(AgeIdPayload $ageIdResponse): void;

    /**
     * Should return previously saved AgeId token
     * @throws AgeIdAuthNotFoundException
     * @return AgeIdPayload
     */
   public function get(): AgeIdPayload;
}