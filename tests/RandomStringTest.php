<?php

use Security\DefuseGenerator;

class RandomStringTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateRandomString()
    {
        for ($i = 1; $i < 100; $i++) {
            $this->assertRegExp('#^[a-zA-Z0-9\-_\+~/.]{'.$i.'}$#', DefuseGenerator::getRandomString($i));
        }
    }

    public function testGenerateVeryLongString()
    {
        $this->assertRegExp('#^[a-zA-Z0-9\-_\+~/.]{10000}$#', DefuseGenerator::getRandomString(10000));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid length. Must be greater than 0.
     */
    public function testInvalidRandomString()
    {
        DefuseGenerator::getRandomString(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid charset. Must contain at least two characters.
     */
    public function testInvalidCharset()
    {
        DefuseGenerator::getRandomString(10, '1');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid charset. Must contain at least two characters.
     */
    public function testInvalid2Charset()
    {
        DefuseGenerator::getRandomString(10, 'aaaaaaa');
    }

    public function testGenerateCapsString()
    {
        $this->assertRegExp('#^[A-Z]{10}$#', DefuseGenerator::getRandomString(10, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
    }
}
