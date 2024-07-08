<?php

/**
 * This file is part of starknet.php package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace StarkNet\Crypto;

use StarkNet\Constants;
use StarkNet\Utils;
use StarkNet\Crypto\Curve;

class PedersenHash
{
    /**
     * hash
     * pedersen hash
     * 
     * @param array $elements
     * @return BigNumber pedersen hash of the elements
     */
    public static function hash($elements)
    {
        return self::pedersenHashAsPoint($elements);
    }

    private static function pedersenHashAsPoint($elements)
    {
        $points = Curve::constantPoints();
        $point = $points[0];
        foreach ($elements as $i => $ox) {
            $x = Utils::toBN($ox);
            $cmpZero = $x->compare(Constants::ZERO());
            assert($cmpZero >= 0 && $x->compare(Utils::toBN('0x' . Constants::FIELD_PRIME)) < 0, "Invalid input $x");
            $pointList = array_slice($points, 2 + $i * Constants::N_ELEMENT_BITS_HASH, Constants::N_ELEMENT_BITS_HASH);
            assert(count($pointList) == Constants::N_ELEMENT_BITS_HASH, 'invalid point list');
            foreach ($pointList as $pt) {
                assert(!$point->getX()->eq($pt->getX()));
                $val = (int) $x->bitwise_and(Constants::ONE())->toString();
                if ($val !== 0) {
                    $point = $point->add($pt);
                }
                $x = $x->bitwise_rightShift(1);
            }
        }
        return $point->getX();
    }
}