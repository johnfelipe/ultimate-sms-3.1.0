<?php

namespace Slydepay;

class TransactionStatusResponse extends Response
{
    protected $response = null;
    protected $statusCodes = [
        1 => 'Success',
        0 => 'Invalid transaction id',
        -1 => 'Invalid pay token'
    ];

    /**
     * @param string  $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function statusCode()
    {
        return $this->response;
    }

    public function status()
    {
        return $this->statusCodes[$this->response];
    }
}
