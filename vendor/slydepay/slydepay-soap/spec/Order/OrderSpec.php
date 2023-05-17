<?php

use Slydepay\Order\Order;
use Slydepay\Order\OrderItems;
use Slydepay\Order\OrderItem;

describe(
    "Order", function () {
        it("should return the Order properties", function () {
            $orderItems = new OrderItems([
                new OrderItem('OR1234', 'Orange', 5, 2),
                new OrderItem('MP1234', 'Mango', 8, 1),
            ]);

            $actualArray = [
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

            $order = Order::createWithId(
                $orderItems,
                "order_id_1",
                12,
                10,
                null,
                null
            );

            expect($order->orderCodeOrId())->toBe("order_id_1");
            expect($order->subTotal())->toBe(18);
            expect($order->shippingCost())->toBe(12);
            expect($order->taxAmount())->toBe(10);
            expect($order->total())->toBe(40);
            expect($order->description())->toBeNull();
            expect($order->comment())->toBeNull();
            expect($order->orderItems())->toBeA('object');
            expect($order->orderItems()->toArray(true))->toBeA('array')->toBe($actualArray);
        });

        it("should return the Order properties ", function () {
                $orderItems = new OrderItems([
                    new OrderItem('OR1234', 'Orange', 5, 2),
                    new OrderItem('MP1234', 'Mango', 8, 1),
                ]);

                $actualArray = [
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

                $order = Order::create(
                    $orderItems,
                    12,
                    10,
                    "description",
                    null
                );

                expect($order->orderCodeOrId())->not->toBeNull();
                expect($order->orderCodeOrId())->toMatch('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i');
                expect($order->subTotal())->toBe(18);
                expect($order->shippingCost())->toBe(12);
                expect($order->taxAmount())->toBe(10);
                expect($order->total())->toBe(40);
                expect($order->description())->not->toBeNull()->toBe("description");
                expect($order->comment())->toBeNull();
                expect($order->orderItems())->toBeA('object');
                expect($order->orderItems()->toArray(true))->toBeA('array')->toBe($actualArray);
            }
        );
    }
);
