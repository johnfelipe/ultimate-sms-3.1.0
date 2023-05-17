<?php

namespace Slydepay;

class ApiQrResponse extends Response
{
    private $response = null;
    private $qrImageUrl = null;
    private $orderCode = null;

    /**
     * @param string  $response
     */
    public function __construct($response, $qrImageUrl = null, $orderCode = null)
    {
        $this->response = $response;
        $this->qrImageUrl = $qrImageUrl;
        $this->orderCode = $orderCode;
    }

    public function redirectUrl()
    {
        return $this->paylive . $this->response;
    }

    public function qrCodeUrl()
    {
        return $this-$this->qrImageUrl;
    }


    public function orderCode()
    {
        return $this->orderCode;
    }
}
