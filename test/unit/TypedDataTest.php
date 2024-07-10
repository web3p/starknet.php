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
}