<?php

namespace Slydepay;

abstract class Response
{
    protected $paylive = 'https://app.slydepay.com.gh/payLIVE/detailsnew.aspx?pay_token=';

    public function redirectUrl()
    {
    }
}
