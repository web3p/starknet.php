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
            'chainId' => [
                'name' => 'chainId',
                'type' => 'felt'
            ],
            'version' => [
                'name' => 'version',
                'type' => 'felt'
            ]
        ];
        $result = TypedData::hashType('StarkNetDomain', [ 'StarkNetDomain' => $revision0Domain ]);
        $this->assertEquals('98d1932052fc5137543de5ed85b7a88555a4cd1ff5d5bfedb62ed9b9a1f0db', $result);
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
        $this->assertEquals('38b9242cb46eb19ff458c80a8f0eda7e8e26d8d6d54a63d9b5ed89750e39ef2', $result);
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
                'chainId' => '1',
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
        $this->assertEquals('6fcff244f63e38b9d88b9e3378d44757710d1b244282b435cb472053c8d78d0', $result);
    }
}