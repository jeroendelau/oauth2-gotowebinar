<?php
namespace DalPraS\OAuth2\Client\Response;

use Doctrine\DBAL\Types\ObjectType;

/**
 * Class ApiResponse
 * @package DalPraS\OAuth2\Client\Response
 */
class ApiResponse
{

    public $response;
    protected $type;
    protected $path;
    protected $args;

    public function __construct($response, $type = "", $path = "", $args = "")
    {
        $this->response = $response;
        $this->type = $type;
        $this->path = $path;
        $this->args = $args;
    }

    public function getData(){
        // Non paged response
        if (isset($this->response['response'])) {
            return $this->response['response'];
        }

        // Paged response
        if (isset($this->response['_embedded'])) {
            return $this->response['_embedded'][$this->type];
        }

        // empty paged response
        if (isset($this->response['page'])) {
            return [];
        }

        // Others
        return $this->response;
    }

    public function getPaging(){
        return $this->response['page'];
    }
}
