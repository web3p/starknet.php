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
        $result = TypedData::hashDomain([
            'name' => 'Paradex',
            'chainId' => 'PRIVATE_SN_POTC_SEPOLIA',
            'version' => 1
        ]);
        $this->assertEquals('38b9242cb46eb19ff458c80a8f0eda7e8e26d8d6d54a63d9b5ed89750e39ef2', $result);
    }
}