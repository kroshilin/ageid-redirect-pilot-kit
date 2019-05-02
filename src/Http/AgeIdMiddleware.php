<?php

namespace Kroshilin\AgeId\Http;


use Kroshilin\AgeId\AgeIdService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AgeIdMiddleware implements MiddlewareInterface
{
    private $ageIdService;

    public function __construct(AgeIdService $ageIdService)
    {
        $this->ageIdService = $ageIdService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \AgeId\AgeIdException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $config = $this->ageIdService->getConfig();

        if ($config->enabled && (!count($config->countries) || in_array($request->getAttribute($config->countryCodeAttributeName), $config->countries))) {
            $motherHost = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost();
            $redirectToAgeIdUrl = $this->ageIdService->getRedirectUrlToAgeId(
                $motherHost .
                $config->ageIdHandlerUrl . '/' . $request->getUri());
            try {
                $payload = $this->ageIdService->getPersister()->get();
                if ($this->ageIdService->isAgeIdPayloadValid($payload)) {
                    return $handler->handle($request);
                }
            } catch (AgeIdAuthNotFoundException $e) {
                $payload = null;
            }

            header('Location:' . $motherHost . $config->noAgeIdAuthFoundUrl ."?{$config->redirectToAgeIdParamName}=" . urlencode($redirectToAgeIdUrl));
            die;
        }

        return $handler->handle($request);
    }
}
