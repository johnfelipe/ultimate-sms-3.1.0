<?php
/**
 * Created by IntelliJ IDEA.
 * User: joseph
 * Date: 4/17/17
 * Time: 1:24 PM
 */

namespace Slydepay;

class Helper
{
    public static function isGUID($payToken)
    {
        return !empty($payToken) && preg_match(
            '/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i',
            $payToken
        );
    }

    public static function calculateTax($taxPercentage, $subTotal)
    {
        return $taxPercentage*$subTotal/100;
    }

    public static function hasProperty($clazz, $property)
    {
        return property_exists($clazz, $property);
    }

    public static function isNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question)==='');
    }
}
