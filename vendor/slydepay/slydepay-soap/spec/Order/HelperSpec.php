<?php
/**
 * Created by IntelliJ IDEA.
 * User: joseph
 * Date: 4/17/17
 * Time: 3:15 PM
 */

use Slydepay\Helper;

describe("Helper", function () {
    it("Should return true on correct GUID format", function () {
        //Got random GUID from https://www.uuidgenerator.net/guid
        $onlineGuid = "ba912958-c136-4eeb-9ac7-f89cd64db966";
        expect(Helper::isGUID($onlineGuid))->toBeTruthy();
    });

    it("Should return false on wrong GUID format", function () {
        //Got random GUID from https://www.uuidgenerator.net/guid
        $onlineGuid = "ba912958-c136f89cd64db966";
        expect(Helper::isGUID($onlineGuid))->toBeFalsy();
    });

    it("Should return correct tax amount", function () {
        $amount = 80;
        $tax = 4;
        $expected = 3.2;
        expect(Helper::calculateTax($tax, $amount))->toBe($expected);
    });

    it("Should return true if class has passed property", function () {
        $testClass = new \stdClass();
        $testClass->title = "Ansible for dummy";
        $testClass->author = "Mr snoopy";
        expect(Helper::hasProperty($testClass, 'title'))->toBeTruthy();
    });


    it("Should return false if class lacks passed property", function () {
        $testClass = new \stdClass();
        $testClass->title = "Ansible for dummy";
        $testClass->author = "Mr snoopy";
        expect(Helper::hasProperty($testClass, 'error'))->toBeFalsy();
    });

    it("Should return true if null or empty", function () {
             $emptyVar = "";
             $nullVar = null;
            expect(Helper::isNullOrEmptyString($emptyVar))->toBeTruthy();
            expect(Helper::isNullOrEmptyString($nullVar))->toBeTruthy();
    });

    it("Should return false if  not null", function () {
             $notEmptyVar = "contains something";
            expect(Helper::isNullOrEmptyString($notEmptyVar))->toBeFalsy();
    });
});
