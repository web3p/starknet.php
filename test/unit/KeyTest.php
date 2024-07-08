<?php

namespace Test\Unit;

use InvalidArgumentException;
use stdClass;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;
use StarkNet\Crypto\Key;
use StarkNet\Constants;

class KeyTest extends TestCase
{
    /**
     * testGrindKey
     * 
     * @return void
     */
    public function testGrindKey()
    {
        $result = Key::grindKey('86F3E7293141F20A8BAFF320E8EE4ACCB9D4A4BF2B4D295E8CEE784DB46E0519');
        $this->assertEquals('05c8c8683596c732541a59e03007b2d30dbbbb873556fe65b5fb63c16688f941', $result);

        $result = Key::grindKey('94F3E7293141F20A8BAFF320E8EE4ACCB9D4A4BF2B4D295E8CEE784DB46E0595');
        $this->assertEquals('033880b9aba464c1c01c9f8f5b4fc1134698f9b0a8d18505cab6cdd34d93dc02', $result);
    }

    /**
     * testGetPublicKey
     * 
     * @return void
     */
    public function testGetPublicKey()
    {
        $result = Key::getPublicKey('2dccce1da22003777062ee0870e9881b460a8b7eca276870f57c601f182136c');
        $this->assertEquals('0400499f65ae2f71d5298d2d88823b2e5e19596a71aac1984710479e406a00243904745865467631492cf6ecc433a3cf4ecc580d698097d6b738ad8f3da7c4d66c', $result);
    }

    /**
     * testGetStarkKey
     * 
     * @return void
     */
    public function testGetStarkKey()
    {
        $result = Key::getStarkKey('0x178047D3869489C055D7EA54C014FFB834A069C9595186ABE04EA4D1223A03F');
        $this->assertEquals('0x1895a6a77ae14e7987b9cb51329a5adfb17bd8e7c638f92d6892d76e51cebcf', $result);

        $result = Key::getStarkKey('0x019800ea6a9a73f94aee6a3d2edf018fc770443e90c7ba121e8303ec6b349279');
        $this->assertEquals('0x33f45f07e1bd1a51b45fc24ec8c8c9908db9e42191be9e169bfcac0c0d99745', $result);
    }

    /**
     * testEthSigToPrivate
     * 
     * @return void
     */
    public function testEthSigToPrivate()
    {
        $sig = '0x21fbf0696d5e0aa2ef41a2b4ffb623bcaf070461d61cf7251c74161f82fec3a43' .
                '70854bc0a34b3ab487c1bc021cd318c734c51ae29374f2beb0e6f2dd49b4bf41c';
        $result = Key::ethSigToPrivate($sig);
        $this->assertEquals('0766f11e90cd7c7b43085b56da35c781f8c067ac0d578eabdceebc4886435bda', $result);
    }
}