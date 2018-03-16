<?php

namespace OAuth2\Grant\Implicit\Options;

use Zend\Stdlib\AbstractOptions;

class ServerOptions extends AbstractOptions
{
    const ACCESS_TOKEN_KEY = 'access_token';
    const RESPONSE_TYPE = 'token';

    /**
     * @var string
     */
    protected $authenticationUri = '';

    /**
     * @var string
     */
    protected $supportedResponseType = self::RESPONSE_TYPE;

    /**
     * @var string
     */
    protected $accessTokenQueryKey = self::ACCESS_TOKEN_KEY;

    /**
     * @return string
     */
    public function getAuthenticationUri(): string
    {
        return $this->authenticationUri;
    }

    /**
     * @param string $authenticationUri
     * @return ServerOptions
     */
    public function setAuthenticationUri(string $authenticationUri): ServerOptions
    {
        $this->authenticationUri = $authenticationUri;

        return $this;
    }

    /**
     * @return string
     */
    public function getSupportedResponseType(): string
    {
        return $this->supportedResponseType;
    }

    /**
     * @param string $availableResponseType
     */
    public function setSupportedResponseType(string $responseType): ServerOptions
    {
        $this->supportedResponseType = $responseType;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessTokenQueryKey(): string
    {
        return $this->accessTokenQueryKey;
    }

    /**
     * @param string $accessTokenQueryKey
     */
    public function setAccessTokenQueryKey(string $accessTokenQueryKey)
    {
        $this->accessTokenQueryKey = $accessTokenQueryKey;

        return $this;
    }
}