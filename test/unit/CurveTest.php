<?php

namespace Test\Unit;

use Test\TestCase;
use StarkNet\Crypto\Curve;

class CurveTest extends TestCase
{
    /**
     * testSignCases
     * 
     * @var array
     */
    protected $testSignCases = [
        [
            'msg' => 'c465dd6b1bbffdb05442eb17f5ca38ad1aa78a6f56bf4415bdee219114a47',
            'result' => [
                '5f496f6f210b5810b2711c74c15c05244dad43d18ecbbdbe6ed55584bc3b0a2',
                '4e8657b153787f741a67c0666bad6426c3741b478c8eaa3155196fc571416f3'
            ],
        ], [
            'msg' => '00c465dd6b1bbffdb05442eb17f5ca38ad1aa78a6f56bf4415bdee219114a47',
            'result' => [
                '5f496f6f210b5810b2711c74c15c05244dad43d18ecbbdbe6ed55584bc3b0a2',
                '4e8657b153787f741a67c0666bad6426c3741b478c8eaa3155196fc571416f3'
            ],
        ], [
            'msg' => 'c465dd6b1bbffdb05442eb17f5ca38ad1aa78a6f56bf4415bdee219114a47a',
            'result' => [
                '233b88c4578f0807b4a7480c8076eca5cfefa29980dd8e2af3c46a253490e9c',
                '28b055e825bc507349edfb944740a35c6f22d377443c34742c04e0d82278cf1'
            ],
        ], [
            'msg' => '7465dd6b1bbffdb05442eb17f5ca38ad1aa78a6f56bf4415bdee219114a47a1',
            'result' => [
                'b6bee8010f96a723f6de06b5fa06e820418712439c93850dd4e9bde43ddf',
                '1a3d2bc954ed77e22986f507d68d18115fa543d1901f5b4620db98e2f6efd80'
            ],
        ]
    ];

    /**
     * testSign
     * 
     * @return void
     */
    public function testSign()
    {
        $privateKey = '2dccce1da22003777062ee0870e9881b460a8b7eca276870f57c601f182136c';
        foreach ($this->testSignCases as $testCase) {
            $result = Curve::sign($privateKey, $testCase['msg']);
            $this->assertEquals($testCase['result'], $result);
        }
    }
}