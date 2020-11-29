<?php

namespace DalPraS\OAuth2\Client\Resources;

use DalPraS\OAuth2\Client\Response\ApiResponse;

class Webhook extends AuthenticatedResourceAbstract
{
    CONST REGISTRANT_ADDED = "registrant.added";
    CONST REGISTRANT_JOINED = "registrant.joined";
    CONST WEBNINAR_CREATED = "webinar.created";
    CONST WEBNINAR_CHANGED = "webinar.changed";
    /**
     * @param array $params
     * @return ApiResponse|mixed
     */
    public function get($path = "/webhooks", $params = [])
    {
        return new ApiResponse($this->request("get", $path, $params, null, false), 'webhooks', $path, $params);
    }

    /**
     * @param array $params
     * @return ApiResponse|mixed
     */
    public function post($path = "/webhooks", $params = [], $body = null)
    {
        return new ApiResponse($this->request("post", $path, $params, $body, false), 'webhooks', $path, $params, $body);
    }

    /**
     * @param array $params
     * @return ApiResponse|mixed
     */
    public function put($path = "/webhooks", $params = [], $body = null)
    {
        return new ApiResponse($this->request("put", $path, $params, $body, false), 'webhooks', $path, $params, $body);
    }

    /**
     * @param $callback
     * @return ApiResponse|mixed
     */
    public function secretKey()
    {
        return $this->post('/webhooks/secretkey');
    }

    /**
     * @param string $callback
     * @param string $event
     * @param string $version
     * @param string $product
     * @return ApiResponse|mixed
     */
    public function create($callback, $events, $version = '1.0.0', $product = 'g2w')
    {
        $callbacks = array_map(function($event) use ($callback, $version, $product) {
            return [
                'callbackUrl' => $callback,
                'eventName' => $event,
                'eventVersion' => $version,
                'product' => $product
            ];
        }, $events);
        return $this->post('/webhooks', null, $callbacks );
    }

    /**
     * @param $webhookKey
     * @return ApiResponse|mixed
     */
    public function getWebhook($webhookKey)
    {
        return $this->get("/webhooks/$webhookKey");
    }

    /**
     * @param string $callback
     * @param string $event
     * @param string $version
     * @param string $product
     * @return ApiResponse|mixed
     */
    public function list()
    {
        return $this->get('/webhooks', [
            'product' => 'g2w'
        ]);
    }


    /**
     * @param $webhookKey
     * @return ApiResponse|mixed
     */
    public function activate($webhookKey)
    {
        return $this->put('/webhooks', null, [[
            'state' => "ACTIVE",
            'webhookKey' => $webhookKey
        ]]);
    }

    /**
     * @param $webhookKey
     * @return ApiResponse|mixed
     */
    public function deactivate($webhookKey)
    {
        return $this->put('/webhooks', null, [[
            'state' => "INACTIVE",
            'webhookKey' => $webhookKey
        ]]);
    }
}
