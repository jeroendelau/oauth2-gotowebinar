<?php

namespace DalPraS\OAuth2\Client\Resources;

use DalPraS\OAuth2\Client\Decorators\AccessTokenDecorator;
use DalPraS\OAuth2\Client\Response\ApiResponse;
use Google\Protobuf\Api;

class UserSubscription extends AuthenticatedResourceAbstract
{
    /**
     * @param array $params
     * @return ApiResponse|mixed
     */
    public function get($path = "/userSubscriptions", $params = [])
    {
        return new ApiResponse($this->request("get", $path, $params, null, false), 'userSubscriptions', $path, $params);
    }

    /**
     * @param array $params
     * @return ApiResponse|mixed
     */
    public function post($path = "/userSubscriptions", $params = [], $body = null)
    {
        return new ApiResponse($this->request("post", $path, $params, $body, false), 'userSubscriptions', $path, $params, $body);
    }

    /**
     * @param array $params
     * @return ApiResponse|mixed
     */
    public function put($path = "/userSubscriptions", $params = [], $body = null)
    {
        return new ApiResponse($this->request("put", $path, $params, $body, false), 'userSubscriptions', $path, $params, $body);
    }

    public function subscribeUser($webhookKey){
        return $this->post('/userSubscriptions', null, [[
            'state' => "ACTIVE",
            'webhookKey' => $webhookKey
        ]]);
    }

}
