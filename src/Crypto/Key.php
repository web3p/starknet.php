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

use Exception;
use StarkNet\Constants;
use StarkNet\Utils;

class Key {
    /**
     * grindKey
     * Given a cryptographically-secure seed and a limit, deterministically generates a pseudorandom
     * key in the range [0, limit).
     * This is a reference implementation, and cryptographic security is not guaranteed (for example,
     * it may be vulnerable to side-channel attacks); this function is not recommended for use with key
     * generation on mainnet.
     * 
     * @param BigNumber $keySeed
     * @return string
     */
    public static function grindKey ($keySeed)
    {
        $keySeed = Utils::toBn($keySeed);
        $ecOrder = Utils::toBn(Constants::EC_ORDER);
        $maskDivOrder = Constants::MASK_256()->divide($ecOrder);
        $maxAllowedValue = Constants::MASK_256()->subtract($maskDivOrder[1]);
        for ($i=0; ; $i++) {
            $msg = str_pad($keySeed->toBytes() . Utils::toBn($i)->toBytes(), 33, "\0");
            $key = Utils::toBn(\hash('sha256', $msg, false));
            if ($key->compare($maxAllowedValue) < 0) {
                $result = $key->divide($ecOrder);
                return $result[1]->toHex();
            }
            if ($i === 100000) {
                throw new Exception('grindKey is broken: tried 100k vals');
            }
        }
    }

    /**
     * getPublicKey
     * 
     * @param string $privateKey
     * @param bool $isCompressed
     * @param string $enc
     * @return string
     */
    public static function getPublicKey ($privateKey, $isCompressed = false, $enc = 'hex')
    {
        $ec = Curve::ec();
        $keyPair = $ec->keyFromPrivate($privateKey);
        return $keyPair->getPublic($isCompressed, $enc);
    }

     /**
     * getStarkKey
     * 
     * @param string $privateKey
     * @return string
     */
    public static function getStarkKey ($privateKey)
    {
        $publicKey = self::getPublicKey($privateKey, true, '');
        return '0x' . preg_replace('/^0+/', '', $publicKey->getX()->toString(16));
    }
}