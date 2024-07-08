<?php

namespace Test\Unit;

use InvalidArgumentException;
use stdClass;
use Test\TestCase;
use phpseclib\Math\BigInteger as BigNumber;
use StarkNet\Utils;
use StarkNet\Constants;

class UtilsTest extends TestCase
{
    /**
     * testHex
     * 'hello world'
     * you can check by call pack('H*', $hex)
     * 
     * @var string
     */
    protected $testHex = '68656c6c6f20776f726c64';

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * testToHex
     * 
     * @return void
     */
    public function testToHex()
    {
        $this->assertEquals($this->testHex, Utils::toHex('hello world'));
        $this->assertEquals('0x' . $this->testHex, Utils::toHex('hello world', true));

        $this->assertEquals('0x927c0', Utils::toHex(0x0927c0, true));
        $this->assertEquals('0x363030303030', Utils::toHex('600000', true));
        $this->assertEquals('0x927c0', Utils::toHex(600000, true));
        $this->assertEquals('0x927c0', Utils::toHex(new BigNumber(600000), true));
        
        $this->assertEquals('0xea60', Utils::toHex(0x0ea60, true));
        $this->assertEquals('0x3630303030', Utils::toHex('60000', true));
        $this->assertEquals('0xea60', Utils::toHex(60000, true));
        $this->assertEquals('0xea60', Utils::toHex(new BigNumber(60000), true));

        $this->assertEquals('0x', Utils::toHex(0x00, true));
        $this->assertEquals('0x30', Utils::toHex('0', true));
        $this->assertEquals('0x', Utils::toHex(0, true));
        $this->assertEquals('0x', Utils::toHex(new BigNumber(0), true));

        $this->assertEquals('0x30', Utils::toHex(48, true));
        $this->assertEquals('0x3438', Utils::toHex('48', true));
        $this->assertEquals('30', Utils::toHex(48));
        $this->assertEquals('3438', Utils::toHex('48'));

        $this->assertEquals('0x30', Utils::toHex(new BigNumber(48), true));
        $this->assertEquals('0x30', Utils::toHex(new BigNumber('48'), true));
        $this->assertEquals('30', Utils::toHex(new BigNumber(48)));
        $this->assertEquals('30', Utils::toHex(new BigNumber('48')));

        $this->expectException(InvalidArgumentException::class);
        $hex = Utils::toHex(new stdClass);
    }

    /**
     * testHexToBin
     * 
     * @return void
     */
    public function testHexToBin()
    {
        $str = Utils::hexToBin($this->testHex);
        $this->assertEquals($str, 'hello world');

        $str = Utils::hexToBin('0x' . $this->testHex);
        $this->assertEquals($str, 'hello world');

        $str = Utils::hexToBin('0xe4b883e5bda9e7a59ee4bb99e9b1bc');
        $this->assertEquals($str, '七彩神仙鱼');

        $this->expectException(InvalidArgumentException::class);
        $str = Utils::hexToBin(new stdClass);
    }

    /**
     * testIsZeroPrefixed
     * 
     * @return void
     */
    public function testIsZeroPrefixed()
    {
        $isPrefixed = Utils::isZeroPrefixed($this->testHex);
        $this->assertEquals($isPrefixed, false);

        $isPrefixed = Utils::isZeroPrefixed('0x' . $this->testHex);
        $this->assertEquals($isPrefixed, true);

        $this->expectException(InvalidArgumentException::class);
        $isPrefixed = Utils::isZeroPrefixed(new stdClass);
    }

    /**
     * testStripZero
     *
     * @return void
     */
    public function testStripZero()
    {
        $str = Utils::stripZero($this->testHex);

        $this->assertEquals($str, $this->testHex);

        $str = Utils::stripZero('0x' . $this->testHex);

        $this->assertEquals($str, $this->testHex);
    }

    /**
     * testSha3
     * 
     * @return void
     */
    public function testSha3()
    {
        $str = Utils::sha3('');
        $this->assertNull($str);

        $str = Utils::sha3('baz(uint32,bool)');
        $this->assertEquals(mb_substr($str, 0, 10), '0xcdcd77c0');

        $this->expectException(InvalidArgumentException::class);
        $str = Utils::sha3(new stdClass);
    }

    /**
     * testIsHex
     * 
     * @return void
     */
    public function testIsHex()
    {
        $isHex = Utils::isHex($this->testHex);

        $this->assertTrue($isHex);

        $isHex = Utils::isHex('0x' . $this->testHex);

        $this->assertTrue($isHex);

        $isHex = Utils::isHex('hello world');

        $this->assertFalse($isHex);
    }

    /**
     * testIsNegative
     * 
     * @return void
     */
    public function testIsNegative()
    {
        $isNegative = Utils::isNegative('-1');
        $this->assertTrue($isNegative);

        $isNegative = Utils::isNegative('1');
        $this->assertFalse($isNegative);
    }

    /**
     * testToBn
     * 
     * @return void
     */
    public function testToBn()
    {
        $bn = Utils::toBn('');
        $this->assertEquals($bn->toString(), '0');

        $bn = Utils::toBn(11);
        $this->assertEquals($bn->toString(), '11');

        $bn = Utils::toBn('0x12');
        $this->assertEquals($bn->toString(), '18');

        $bn = Utils::toBn('-0x12');
        $this->assertEquals($bn->toString(), '-18');

        $bn = Utils::toBn(0x12);
        $this->assertEquals($bn->toString(), '18');

        $bn = Utils::toBn('ae');
        $this->assertEquals($bn->toString(), '174');

        $bn = Utils::toBn('-ae');
        $this->assertEquals($bn->toString(), '-174');

        $bn = Utils::toBn('-1');
        $this->assertEquals($bn->toString(), '-1');

        $bn = Utils::toBn('-0.1');
        $this->assertEquals(count($bn), 4);
        $this->assertEquals($bn[0]->toString(), '0');
        $this->assertEquals($bn[1]->toString(), '1');
        $this->assertEquals($bn[2], 1);
        $this->assertEquals($bn[3]->toString(), '-1');

        $bn = Utils::toBn(-0.1);
        $this->assertEquals(count($bn), 4);
        $this->assertEquals($bn[0]->toString(), '0');
        $this->assertEquals($bn[1]->toString(), '1');
        $this->assertEquals($bn[2], 1);
        $this->assertEquals($bn[3]->toString(), '-1');

        $bn = Utils::toBn('0.1');
        $this->assertEquals(count($bn), 4);
        $this->assertEquals($bn[0]->toString(), '0');
        $this->assertEquals($bn[1]->toString(), '1');
        $this->assertEquals($bn[2], 1);
        $this->assertEquals($bn[3], false);

        $bn = Utils::toBn('-1.69');
        $this->assertEquals(count($bn), 4);
        $this->assertEquals($bn[0]->toString(), '1');
        $this->assertEquals($bn[1]->toString(), '69');
        $this->assertEquals($bn[2], 2);
        $this->assertEquals($bn[3]->toString(), '-1');

        $bn = Utils::toBn(-1.69);
        $this->assertEquals($bn[0]->toString(), '1');
        $this->assertEquals($bn[1]->toString(), '69');
        $this->assertEquals($bn[2], 2);
        $this->assertEquals($bn[3]->toString(), '-1');

        $bn = Utils::toBn('1.69');
        $this->assertEquals(count($bn), 4);
        $this->assertEquals($bn[0]->toString(), '1');
        $this->assertEquals($bn[1]->toString(), '69');
        $this->assertEquals($bn[2], 2);
        $this->assertEquals($bn[3], false);

        $bn = Utils::toBn(new BigNumber(1));
        $this->assertEquals($bn->toString(), '1');

        $this->expectException(InvalidArgumentException::class);
        $bn = Utils::toBn(new stdClass);
    }

    /**
     * testKeccak
     * 
     * @return void
     */
    public function testKeccak()
    {
        $result = Utils::keccak('hello');
        $this->assertEquals('8aff950685c2ed4bc3174f3472287b56d9517b9c948127319a09a7a36deac8', $result);
        $bn = Utils::toBn($result);
        $this->assertTrue($bn->compare(Constants::MASK_250()) < 0);
    }
}