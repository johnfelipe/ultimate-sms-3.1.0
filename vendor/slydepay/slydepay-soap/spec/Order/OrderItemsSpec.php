<?php

use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;

describe("OrderItems", function () {
    it("should have at least one order item", function () {
        $orderItems = new OrderItems([
            new OrderItem('MP1234', 'Mango', 2, 1)
        ]);
        expect($orderItems->count())->toBeGreaterThan(0);
    });

    it("should give a subtotal of all items", function () {
        $orderItems = new OrderItems([
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ]);
        expect($orderItems->subTotal())->toBe(18);
    });

    it("should return an list of order items", function () {
        $items = [
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ];
        $orderItems = new OrderItems($items);
        expect($orderItems->toArray())->toBeA('array')->toBe($items);
    });

    it("should return an list of order items with array item", function () {
        $items = [
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ];
        $orderItems = new OrderItems($items);

        $actual = [
            [
                'ItemCode' => 'OR1234',
                'ItemName' => 'Orange',
                'UnitPrice' => 5,
                'Quantity' => 2,
                'SubTotal' => 10
            ],
            [
                'ItemCode' => 'MP1234',
                'ItemName' => 'Mango',
                'UnitPrice' => 8,
                'Quantity' => 1,
                'SubTotal' => 8
            ],
        ];
        expect($orderItems->toArray(true))->toBeA('array')->toBe($actual);
    });
});
