<?php

use Slydepay\TransactionStatusResponse;

describe("TransactionStatusResponse", function () {
    it("should return success", function () {
        $response = new TransactionStatusResponse(1);
        expect($response->status())->toBe('Success');
        expect($response->statusCode())->toBe(1);
    });

    it("should return invalid transaction id", function () {
        $response = new TransactionStatusResponse(0);
        expect($response->status())->toBe('Invalid transaction id');
        expect($response->statusCode())->toBe(0);
    });

    it("should return invalid pay token", function () {
        $response = new TransactionStatusResponse(-1);
        expect($response->status())->toBe('Invalid pay token');
        expect($response->statusCode())->toBe(-1);
    });
});
