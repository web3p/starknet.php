<?php

namespace Test\Unit;

use InvalidArgumentException;
use stdClass;
use Test\TestCase;
use StarkNet\Crypto\PoseidonHash;

/**
 * TODO: more test for poseidon hash
 */
class PoseidonHashTest extends TestCase
{
    /**
     * testHash
     * @see https://github.com/paulmillr/noble-curves/blob/main/test/poseidon.test.ts
     * @return void
     */
    public function testPoseidonHash()
    {
        $result = PoseidonHash::poseidonHash([
            '4379311784651118086770398084575492314150568148003994287303975907890254409956',
            '5329163686893598957822497554130545759427567507701132391649270915797304266381',
            2
        ]);
        $this->assertEquals('2457757238178986673695038558497063891521456354791980183317105434323761563347', $result[0]->toString());
    }
}