<?php

namespace Slydepay;

class ApiResponse extends Response
{
    protected $response = null;

    /**
     * @param string  $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function redirectUrl()
    {
        return $this->paylive . $this->response;
    }
}
