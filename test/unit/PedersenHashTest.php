<?php

namespace Test\Unit;

use InvalidArgumentException;
use stdClass;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;
use StarkNet\Crypto\PedersenHash;
use StarkNet\Crypto\FastPedersenHash;

/**
 * TODO: more test for pedersen hash
 */
class PedersenHashTest extends TestCase
{
    /**
     * testHash
     * 
     * @return void
     */
    public function testHash()
    {
        $result = PedersenHash::hash([0, '1859938899453001548362772938057778066833094073841168374380996652312065025102']);
        $this->assertEquals('0687ea8d6d09d2106b3f9d69796bf12c54706f0cdc43b63ee73d4f9bc74b454f', $result->toString(16));

        $result = PedersenHash::hash(['2954020266725389012079514584454222423700048665778967545305932093381394777423', '215307247182100370520050591091822763712463273430149262739280891880522753123']);
        $this->assertEquals('02e77dfc2f710d7b4d70028905487511fb49576ee767575225a36db365250475', $result->toString(16));
    }

    /**
     * testHashFast
     * 
     * @return void
     */
    public function testHashFast()
    {
        $result = FastPedersenHash::hash(0, '1859938899453001548362772938057778066833094073841168374380996652312065025102');
        $this->assertEquals('0687ea8d6d09d2106b3f9d69796bf12c54706f0cdc43b63ee73d4f9bc74b454f', $result->toString(16));

        $result = FastPedersenHash::hash('2954020266725389012079514584454222423700048665778967545305932093381394777423', '215307247182100370520050591091822763712463273430149262739280891880522753123');
        $this->assertEquals('02e77dfc2f710d7b4d70028905487511fb49576ee767575225a36db365250475', $result->toString(16));
    }
}