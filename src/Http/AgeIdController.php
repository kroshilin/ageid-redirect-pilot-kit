<?php

namespace Kroshilin\AgeId\Http;


use Kroshilin\AgeId\AgeIdPayload;
use Kroshilin\AgeId\AgeIdService;
use Psr\Http\Message\ServerRequestInterface;

class AgeIdController
{
    private $ageIdService;

    public function __construct(AgeIdService $ageIdService)
    {
        $this->ageIdService = $ageIdService;
    }

    /**
     * @param ServerRequestInterface $request
     * @throws \AgeId\AgeIdException
     */
    public function processAgeIdCallback(ServerRequestInterface $request)
    {
        $config = $this->ageIdService->getConfig();
        $motherHost = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost() . ($request->getUri()->getPort() ? ":" . $request->getUri()->getPort() : '');
        if ($rawPayload = $request->getQueryParams()['payload'] ?? false) {
            $decodedPayload = $this->ageIdService->getEncrypter()->decrypt($rawPayload);
            $payload = new AgeIdPayload($decodedPayload['status'] ?? 'Decrypt Error');
            if ($this->ageIdService->isAgeIdPayloadValid($payload)) {
                $this->ageIdService->getPersister()->save($payload);
                header("Location: " . urldecode($request->getAttribute('redirect')));
                die;
            }
        }

        if ($error = $request->getQueryParams()['error'] ?? false) {
            if ($error === 'unauthorized') {
                header("Location: " .
                    $config->ageIdApiBaseUrl . "/login?client_url=" .
                    $request->getAttribute('redirect')
                );
                die;
            }
        }

        if (($decodedPayload["status"] ?? false) === AgeIdPayload::STATUS_UNVERIFIED) {
            header("Location: " . $motherHost . $config->unVerifiedAgeIdUrl);
            die;
        }

        header("Location: " . $motherHost . $config->unexpectedAgeIdErrorUrl);
    }
}