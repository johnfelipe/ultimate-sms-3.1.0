<?php

namespace Slydepay\Order;

class Order
{
    private $orderCodeOrId;
    private $subTotal;
    private $shippingCost;
    private $taxAmount;
    private $total;
    private $description;
    private $comment;
    private $orderItems = [];

    /**
     * @param OrderItems $orderItems list of items purchased to be paid for by customer
     * @param $orderCodeOrId unique order code or id
     * @param $subTotal order subtotal without any other cost associated
     * @param $shippingCost order shipping cost if there is any. It will be added to total cost.
     * @param $taxAmount order tax if applicable. It will be added to total cost.
     * @param $description known as comment1 on slydepay API, can provide description to show to customer
     * @param $comment known as comment2 on slydepay API, can provide further details on order
     */
    private function __construct(
        OrderItems $orderItems,
        $orderCodeOrId,
        $shippingCost,
        $taxAmount,
        $description,
        $comment = null
    ) {
    
        $this->orderCodeOrId = $orderCodeOrId;
        $this->subTotal = $orderItems->subTotal();
        $this->shippingCost = $shippingCost;
        $this->taxAmount = $taxAmount;
        $this->total = $orderItems->subTotal() + $shippingCost + $taxAmount;
        $this->description = $description;
        $this->comment = $comment;
        $this->orderItems = $orderItems;
    }

    /**
     * Create an order with an orderCode generated automatically
     * 
     * @param OrderItems $orderItems list of items purchased to be paid for by customer
     * @param $subTotal order subtotal without any other cost associated
     * @param $shippingCost order shipping cost if there is any. It will be added to total cost.
     * @param $taxAmount order tax if applicable. It will be added to total cost.
     * @param $description known as comment1 on slydepay API, can provide description to show to customer
     * @param $comment known as comment2 on slydepay API, can provide further details on order
     */
    public static function create(
        OrderItems $orderItems,
        $shippingCost,
        $taxAmount,
        $description,
        $comment = null
    ) {
        $orderCode = self::generateGUID();

        return new self(
            $orderItems,
            $orderCode,
            $shippingCost,
            $taxAmount,
            $description,
            $comment
        );
    }

    /**
     * Create an order with an orderId explicitly passed as a parameter
     * 
     * @param OrderItems $orderItems list of items purchased to be paid for by customer
     * @param $orderId unique order id
     * @param $subTotal order subtotal without any other cost associated
     * @param $shippingCost order shipping cost if there is any. It will be added to total cost.
     * @param $taxAmount order tax if applicable. It will be added to total cost.
     * @param $description known as comment1 on slydepay API, can provide description to show to customer
     * @param $comment known as comment2 on slydepay API, can provide further details on order
     */
    public static function createWithId(
        OrderItems $orderItems,
        $orderId,
        $shippingCost,
        $taxAmount,
        $description,
        $comment = null
    ) {
        return new self(
            $orderItems,
            $orderId,
            $shippingCost,
            $taxAmount,
            $description,
            $comment
        );
    }

    public function subTotal()
    {
        return $this->subTotal;
    }

    public function shippingCost()
    {
        return $this->shippingCost;
    }

    public function taxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @return string
     */
    public function orderCodeOrId()
    {
        return $this->orderCodeOrId;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function comment()
    {
        return $this->comment;
    }

    /**
     * @return OrderItems
     */
    public function orderItems()
    {
        return $this->orderItems;
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Generate a GUID string
     * code taken from http://php.net/manual/en/function.com-create-guid.php#99425
     * @return string
     */
    private static function generateGUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf(
            '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }
}
