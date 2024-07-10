<?php

namespace Test\Unit;

use InvalidArgumentException;
use stdClass;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;
use StarkNet\Hash;

class HashTest extends TestCase
{
    /**
     * setUp
     * 
     * @return void
     */
    // public function setUp(): void
    // {
    //     parent::setUp();
    // }

    /**
     * testComputeAddress
     * 
     * @return void
     */
    public function testComputeAddress()
    {
        $result = Hash::computeAddress(
            '951442054899045155353616354734460058868858519055082696003992725251069061570',
            [
                21,
                37
            ],
            1111
        );
        $this->assertEquals('30018328ec720e778744bfeec50d93bad01215f53b7a09e7c8b724157c2d947', $result);

        $result = Hash::computeAddress(
            '951442054899045155353616354734460058868858519055082696003992725251069061570',
            [
                21,
                37
            ],
            1111,
            1234
        );
        $this->assertEquals('707c2720b9dc5fb42ff24eeef04ddff509fcf2f86371cbf9a344de8638bd4a8', $result);
    }
}