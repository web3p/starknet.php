<?php

namespace Test\Unit;

use InvalidArgumentException;
use Test\TestCase;
use StarkNet\Cairo\Felt;

class FeltTest extends TestCase
{
    /**
     * testEncodeShortString
     * 
     * @return void
     */
    public function testEncodeShortString()
    {
        $result = Felt::encodeShortString('hello');
        $this->assertEquals('68656c6c6f', $result);
    }

    /**
     * testDecodeShortString
     * 
     * @return void
     */
    public function testDecodeShortString()
    {
        $result = Felt::decodeShortString('68656c6c6f');
        $this->assertEquals('hello', $result);
    }
}