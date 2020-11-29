<?php

namespace DalPraS\OAuth2\Client\Resources;

use DalPraS\OAuth2\Client\Decorators\AccessTokenDecorator;
use DalPraS\OAuth2\Client\Provider\GotoWebinar;
use League\OAuth2\Client\Token\AccessToken;

abstract class AuthenticatedResourceAbstract
{

    /**
     * @var \DalPraS\OAuth2\Client\Provider\GotoWebinar
     */
    protected $provider;

    /**
     * Original League AccessToken
     *
     * @var \League\OAuth2\Client\Token\AccessToken
     */
    protected $accessToken;

    /**
     * @param \DalPraS\OAuth2\Client\Provider\GotoWebinar $provider
     * @param \League\OAuth2\Client\Token\AccessToken $accessToken
     */
    public function __construct(GotoWebinar $provider, AccessToken $accessToken)
    {
        $this->provider = $provider;
        $this->accessToken = $accessToken;
    }

    public function request($method, $path, $params = [], $body = null, $withOrganizer = true)
    {

        $url = $this->provider->domain . '/G2W/rest/v2';
        if ($withOrganizer) {
            $url .= '/organizers/' . (new AccessTokenDecorator($this->accessToken))->getOrganizerKey();
        }
        $url .= $path;

        if(!empty($params)){
            $url .= '?' . http_build_query($params, null, '&', \PHP_QUERY_RFC3986);
        }

        $options = [];
        if (!empty($body)) {
            $options = [
                'headers' => [
                    'Accept' => 'application/vnd.citrix.g2wapi-v1.1+json',
                ],
                'body' => json_encode($body)
            ];
        }

        $request = $this->provider->getAuthenticatedRequest($method, $url, $this->accessToken, $options);
        if(!$withOrganizer){
            // $request['headers']['Authorization'] =  "Bearer {$this->provider->getAccessToken()}";
        }

        dump("$method $url" , $body);

        return $this->provider->getParsedResponse($request);
    }

}

