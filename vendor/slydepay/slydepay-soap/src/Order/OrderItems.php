<?php

namespace Slydepay\Order;

class OrderItems
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function subTotal()
    {
        return array_reduce($this->items, function ($carry, OrderItem $item) {
            $carry += $item->subTotal();
            return $carry;
        }, 0);
    }

    public function toArray($itemToArray = false)
    {
        if ($itemToArray) {
            return array_map(function (OrderItem $item) {
                return $item->toArray();
            }, $this->items);
        }
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }
}
