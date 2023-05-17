<?php

use Slydepay\Order\OrderItem;

describe("OrderItem", function () {
    it("should return the OrderItem properties", function () {
        $item = new OrderItem('SLYDE:1203920', 'Item One', 5, 1);
        expect($item->ItemCode)->toBe('SLYDE:1203920');
        expect($item->ItemName)->toBe('Item One');
        expect($item->UnitPrice)->toBe(5);
        expect($item->Quantity)->toBe(1);
        expect($item->SubTotal)->toBe(5);
    });

    it("should return subtotal for item with a quantity of 1", function () {
        $item = new OrderItem('SLYDE:1203920', 'Item One', 5, 1);
        expect($item->subTotal())->toBe(5);
    });

    it("should return subtotal for item with a quantity of 4", function () {
        $item = new OrderItem('SLYDE:1203920', 'Item One', 5, 4);
        expect($item->subTotal())->toBe(20);
    });

    it("should return an array of order item", function () {
        $item = new OrderItem('SLYDE:1203920', 'Item One', 5, 4);
        $actual = [
            'ItemCode' => 'SLYDE:1203920',
            'ItemName' => 'Item One',
            'UnitPrice' => 5,
            'Quantity' => 4,
            'SubTotal' => 20
        ];
        expect($item->toArray())->toBeA('array')->toBe($actual);
    });
});
