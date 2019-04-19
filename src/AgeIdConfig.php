<?php

namespace Kroshilin\AgeId;

class AgeIdConfig
{
    /** @var bool */
    public $enabled;
    /** @var string */
    public $ageIdApiBaseUrl;
    /**
     * List of countries' codes where AgeId should be enabled
     *
     * @var array
     */
    public $countries;
    /**
     * Request attribute name that contains country code
     * @var string
     */
    public $countryCodeAttributeName;
    /** @var int */
    public $clientId;
    /** @var string */
    public $clientSecret;
    /**
     * Timeout in minutes
     * @var int
     */
    public $timeout;
    /**
     * Client's site relative url where AgeId should return user after verification
     * @var string
     */
    public $ageIdHandlerUrl;
    /**
     * Client's site relative url where library should redirect user after NO AgeId Auth detected
     * @var string
     */
    public $noAgeIdAuthFoundUrl;
    /**
     * Client's site relative url where library should redirect user after UNVERIFIED AgeId result
     * @var string
     */
    public $unVerifiedAgeIdUrl;
    /**
     * Client's site relative url where library should redirect user after Unexpected AgeId error
     * @var string
     */
    public $unexpectedAgeIdErrorUrl;
    /**
     * Query param to pass url with payload for redirection to AgeId
     * @var string
     */
    public $redirectToAgeIdParamName;

    /**
     * Create a new instance.
     *
     * @param bool $enabled
     * @param string $ageIdApiBaseUrl
     * @param array $countries
     * @param string $countryCodeAttributeName
     * @param int $timeoutInMinutes
     * @param int $clientId
     * @param string $clientSecret
     * @param string $ageIdHandlerUrl
     * @param string $noAgeIdAuthFoundUrl
     * @param string $unVerifiedAgeIdUrl
     * @param string $unexpectedAgeIdErrorUrl
     * @param string $redirectToAgeIdParamName
     */
    public function __construct(bool $enabled, string $ageIdApiBaseUrl, array $countries, string $countryCodeAttributeName, int $timeoutInMinutes, int $clientId, string $clientSecret, string $ageIdHandlerUrl, string $noAgeIdAuthFoundUrl, string $unVerifiedAgeIdUrl, string $unexpectedAgeIdErrorUrl, string $redirectToAgeIdParamName)
    {
        $this->enabled = $enabled;
        $this->ageIdApiBaseUrl = $ageIdApiBaseUrl;
        $this->countries = $countries;
        $this->countryCodeAttributeName = $countryCodeAttributeName;
        $this->clientId = $clientId;
        $this->timeout = $timeoutInMinutes;
        $this->clientSecret = $clientSecret;
        $this->ageIdHandlerUrl = $ageIdHandlerUrl;
        $this->noAgeIdAuthFoundUrl = $noAgeIdAuthFoundUrl;
        $this->unVerifiedAgeIdUrl = $unVerifiedAgeIdUrl;
        $this->unexpectedAgeIdErrorUrl = $unexpectedAgeIdErrorUrl;
        $this->redirectToAgeIdParamName = $redirectToAgeIdParamName;
    }
}
