<?php

namespace Test\Unit;

use InvalidArgumentException;
use stdClass;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;
use StarkNet\Crypto\Key;
use StarkNet\Constants;

class KeyTest extends TestCase
{
    /**
     * testGrindKey
     * 
     * @return void
     */
    public function testGrindKey()
    {

        $result = Key::grindKey('86F3E7293141F20A8BAFF320E8EE4ACCB9D4A4BF2B4D295E8CEE784DB46E0519');
        $this->assertEquals('5c8c8683596c732541a59e03007b2d30dbbbb873556fe65b5fb63c16688f941', substr($result->toString(16), 1, 64));
    }
}