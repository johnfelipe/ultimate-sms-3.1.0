<?php

namespace Slydepay;

use Slydepay\Exception\CancelTransactionException;
use Slydepay\Exception\ConfirmTransactionException;
use Slydepay\Exception\InvalidPayTokenException;
use Slydepay\Exception\MobilePaymentException;
use Slydepay\Exception\ProcessPaymentException;
use Slydepay\Order\Order;
use Slydepay\Order\OrderItems;
use SoapClient;
use SoapHeader;

class Slydepay
{
    private $soap;
    private $namespace = 'http://www.i-walletlive.com/payLIVE';
    private $wsdl = 'https://app.slydepay.com.gh/webservices/paymentservice.asmx?wsdl';
    private $version = '1.4';

    /**
     * @param string  $merchantEmail
     * @param string  $merchantSecretKey
     * @param string  $serviceType
     * @param boolean $integrationMode  set to true when in development mode, set to false for live mode
     */
    public function __construct($merchantEmail, $merchantSecretKey, $serviceType = 'C2B', $integrationMode = true)
    {
        $this->soap = $this->newSoapClient($this->wsdl);
        $headers = [
            'APIVersion' => $this->version,
            'MerchantEmail' => $merchantEmail,
            'MerchantKey' => $merchantSecretKey,
            'SvcType' => $serviceType,
            'UseIntMode' => $integrationMode,
        ];

        $soapHeader = $this->newSoapHeader($this->namespace, $headers);
        $this->soap->__setSoapHeaders($soapHeader);
    }

    /**
     * @param Order $order
     *
     * @return ApiResponse
     */
    public function processPaymentOrder(Order $order)
    {
        try {
            $params = [
                'orderId' => $order->orderCodeOrId(),
                'subtotal' => $order->subTotal(),
                'shippingCost' => $order->shippingCost(),
                'taxAmount' => $order->taxAmount(),
                'total' => $order->total(),
                'comment1' => $order->description(),
                'comment2' => $order->comment(),
                'orderItems' => $order->orderItems()->toArray(),
            ];
            $response = $this->soap->ProcessPaymentOrder($params);
            if (!Helper::isGUID($response->ProcessPaymentOrderResult)) {
                throw new InvalidPayTokenException("Return token is not a valid GUID ::" .
                    $response->ProcessPaymentOrderResult .":: is returned instead");
            }
            return new ApiResponse($response->ProcessPaymentOrderResult);
        } catch (\Exception $e) {
            throw new ProcessPaymentException($e);
        }
    }

    /**
     * @param Order $order
     *
     * @return ApiQrResponse
     */
    public function mobilePaymentOrder(Order $order)
    {
        try {
            $params = [
                'orderId' => $order->orderCodeOrId(),
                'subtotal' => $order->subTotal(),
                'shippingCost' => $order->shippingCost(),
                'taxAmount' => $order->taxAmount(),
                'total' => $order->total(),
                'comment1' => $order->description(),
                'comment2' => $order->comment(),
                'orderItems' => $order->orderItems()->toArray(),
            ];
            $response = $this->soap->mobilePaymentOrder($params);

            if (Helper::hasProperty($response->mobilePaymentOrderResult, 'error')) {
                throw new InvalidPayTokenException("Return token is not a valid GUID ::" .
                    $response->mobilePaymentOrderResult->error ." :: is returned instead");
            }

            return new ApiQrResponse(
                $response->mobilePaymentOrderResult->token,
                $response->mobilePaymentOrderResult->imageUrl,
                $response->mobilePaymentOrderResult->orderCode
            );
        } catch (\Exception $e) {
            throw new MobilePaymentException($e);
        }
    }

    /**
     * @param string $payToken
     * @param string $transactionId
     *
     * @return TransactionStatusResponse
     */
    public function confirmTransaction($payToken, $transactionId)
    {
        try {
            $params = [
                'payToken' => $payToken,
                'transactionId' => $transactionId,
            ];

            $response = $this->soap->ConfirmTransaction($params);
            return new TransactionStatusResponse($response->ConfirmTransactionResult);
        } catch (Exception $e) {
            throw new ConfirmTransactionException($e);
        }
    }

    /**
     * @param string $payToken
     * @param string $transactionId
     *
     * @return TransactionStatusResponse
     */
    public function cancelTransaction($payToken, $transactionId)
    {
        try {
            $params = [
                'payToken' => $payToken,
                'transactionId' => $transactionId,
            ];

            $response = $this->soap->CancelTransaction($params);
            return new TransactionStatusResponse($response->CancelTransactionResult);
        } catch (Exception $e) {
            throw new CancelTransactionException($e);
        }
    }

    protected function newSoapClient($wsdl)
    {
        return new SoapClient($wsdl);
    }

    protected function newSoapHeader($namespace, $headers)
    {
        return new SoapHeader($namespace, "PaymentHeader", $headers);
    }
}
