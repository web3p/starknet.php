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

use Elliptic\EC;
use Elliptic\Curve\PresetCurve;
use StarkNet\Constants;

class Curve
{
    /**
     * ec
     * 
     * @return EC
     */
    public static function ec()
    {
        $sha256 = [ "blockSize" => 512, "outSize" => 256, "hmacStrength" => 192, "padLength" => 64, "algo" => 'sha256' ];
        return new EC(new PresetCurve(array(
            "type" => "short",
            "prime" => null,
            "p" => Constants::FIELD_PRIME,
            "a" => "00000000 00000000 00000000 00000000 00000000 00000000 00000000 00000001",
            "b" => "06f21413 efbe40de 150e596d 72f7a8c5 609ad26c 15c915c1 f4cdfcb9 9cee9e89",
            "n" => Constants::EC_ORDER,
            "hash" => $sha256,
            "gRed" => false,
            "g" => Constants::CONSTANT_POINTS[1]
          )));
    }

    /**
     * constantPoints
     * 
     * @return array array of constant points
     */
    public static function constantPoints()
    {
        return array_map(function ($x) {
            return self::ec()->curve->point($x[0], $x[1]);
        }, Constants::CONSTANT_POINTS);
    }

    /**
     * sign
     * 
     * @param string $pk
     * @param string $message
     * @return array signature
     */
    public static function sign(string $pk, string $message)
    {
        $messageBn = Numbers::toBN(Encode::addHexPrefix($message));
        assert($messageBn->compare(Constants::ZERO()) > 0 || $messageBn->compare(Constants::ZERO()) == 0, 'out of bound');
        $ecdsa = Numbers::toBN(Encode::addHexPrefix(Constants::MAX_ECDSA_VAL));
        assert($messageBn->compare($ecdsa) < 0 || $messageBn->compare($ecdsa) == 0, 'out of bound');
        $signature = self::ec()->sign(self::fixHex($message), $pk);
        return [$signature->r, $signature->s];
    }

    /**
     * fixHex
     * TODO: remove this
     * 
     * @param string $val
     * @return string
     */
    public static function fixHex(string $hex)
    {
        $hex = preg_replace('/^0x0*/', '', $hex);
        if (strlen($hex) <= 62) {
            return $hex;
        } elseif (strlen($hex) === 63) {
            return $hex . "0";
        }
    }
}
