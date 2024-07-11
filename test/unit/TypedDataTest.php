<?php

namespace Test\Unit;

use InvalidArgumentException;
use Test\TestCase;
use StarkNet\TypedData;

class TypedDataTest extends TestCase
{
    /**
     * testHashType
     * 
     * @return void
     */
    public function testHashType()
    {
        $revision0Domain = [
            'name' => [
                'name' => 'name',
                'type' => 'felt'
            ],
            'version' => [
                'name' => 'version',
                'type' => 'felt'
            ],
            'chainId' => [
                'name' => 'chainId',
                'type' => 'felt'
            ]
        ];
        $result = TypedData::hashType('StarkNetDomain', [ 'StarkNetDomain' => $revision0Domain ]);
        $this->assertEquals('0x1bfc207425a47a5dfa1a50a4f5241203f50624ca5fdf5e18755765416b8e288', $result);
    }

    /**
     * testHashDomain
     * 
     * @return void
     */
    public function testHashDomain()
    {
        $result = TypedData::hashDomain([
            'name' => 'Paradex',
            'chainId' => 'PRIVATE_SN_POTC_SEPOLIA',
            'version' => 1
        ]);
        $this->assertEquals('0x56fa2b48bdad922420e72dcb469f1190ee8da485b79df04d4a75c2104d6b57d', $result);

        $result = TypedData::hashDomain([
            'name' => 'StarkNet Mail',
            'version' => 1,
            'chainId' => 1
        ]);
        $this->assertEquals('0x54833b121883a3e3aebff48ec08a962f5742e5f7b973469c1f8f4f55d470b07', $result);
    }

    /**
     * testMessageHash
     * 
     * @return void
     */
    public function testMessageHash()
    {
        $result = TypedData::messageHash([
                'name' => 'StarkNet Mail',
                'chainId' => 1,
                'version' => 1
            ], [
                'Mail' => [
                    [ 'name' => 'from', 'type' => 'Person' ],
                    [ 'name' => 'to', 'type' => 'Person' ],
                    [ 'name' => 'contents', 'type' => 'felt' ]
                ],
                'Person' => [
                    [ 'name' => 'name', 'type' => 'felt' ],
                    [ 'name' => 'wallet', 'type' => 'felt' ]
                ]
            ], [
                'from' => [
                    'name' => 'Cow',
                    'wallet' => '0xCD2a3d9F938E13CD947Ec05AbC7FE734Df8DD826'
                ],
                'to' => [
                    'name' => 'Bob',
                    'wallet' => '0xbBbBBBBbbBBBbbbBbbBbbbbBBbBbbbbBbBbbBBbB'
                ],
                'contents' => 'Hello, Bob!'
            ],
            "0xcd2a3d9f938e13cd947ec05abc7fe734df8dd826"
        );
        $this->assertEquals('0x6fcff244f63e38b9d88b9e3378d44757710d1b244282b435cb472053c8d78d0', $result);
    }
}