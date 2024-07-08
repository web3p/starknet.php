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
        $result = PedersenHash::hash([
            0,
            '1859938899453001548362772938057778066833094073841168374380996652312065025102'
        ]);
        $this->assertEquals('0687ea8d6d09d2106b3f9d69796bf12c54706f0cdc43b63ee73d4f9bc74b454f', $result->toString(16));

        $result = PedersenHash::hash([
            '2954020266725389012079514584454222423700048665778967545305932093381394777423',
            '215307247182100370520050591091822763712463273430149262739280891880522753123'
        ]);
        $this->assertEquals('02e77dfc2f710d7b4d70028905487511fb49576ee767575225a36db365250475', $result->toString(16));
    }

    /**
     * testHashFast
     * 
     * @return void
     */
    public function testHashFast()
    {
        $result = FastPedersenHash::hash(
            '3d937c035c878245caf64531a5756109c53068da139362728feb561405371cb',
            '0x208a0a10250e382e1e4bbe2880906c2791bf6275695e02fbbc6aeff9cd8b31a'
        );
        $this->assertEquals('030e480bed5fe53fa909cc0f8c4d99b8f9f2c016be4c41e13a4848797979c662', $result->toString(16));

        $result = FastPedersenHash::hash(
            '0x58f580910a6ca59b28927c08fe6c43e2e303ca384badc365795fc645d479d45',
            '0x78734f65a067be9bdb39de18434d71e79f7b6466a4b66bbd979ab9e7515fe0b'
        );
        $this->assertEquals('068cc0b76cddd1dd4ed2301ada9b7c872b23875d5ff837b3a87993e0d9996b87', $result->toString(16));
    }
}