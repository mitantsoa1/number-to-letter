<?php

use App\NumberToLetter;
use PHPUnit\Framework\TestCase;

class NumberToLetterTest extends TestCase
{
    public function testConvert()
    {
        $numberToLetter = new NumberToLetter();
        $this->assertEquals("zéro", $numberToLetter->convertNumberToLetter(0));
        $this->assertEquals("cinq", $numberToLetter->convertNumberToLetter(5));
        $this->assertEquals("vingt", $numberToLetter->convertNumberToLetter(20));
        $this->assertEquals("vingt un", $numberToLetter->convertNumberToLetter(21));
        $this->assertEquals("moins vingt", $numberToLetter->convertNumberToLetter(-20));
        $this->assertEquals("soixante dix", $numberToLetter->convertNumberToLetter(70));
        $this->assertEquals("soixante onze", $numberToLetter->convertNumberToLetter(71));
        $this->assertEquals("quatre vingt", $numberToLetter->convertNumberToLetter(80));
        $this->assertEquals("quatre vingt un", $numberToLetter->convertNumberToLetter(81));
        $this->assertEquals("cent quatre vingt un", $numberToLetter->convertNumberToLetter(181));
        $this->assertEquals("neuf cent", $numberToLetter->convertNumberToLetter(900));
        $this->assertEquals("Un milliard", $numberToLetter->convertNumberToLetter(1000000000));
        $this->assertEquals("onze milliards deux cent deux", $numberToLetter->convertNumberToLetter(11000000202));
        $this->assertEquals("neuf millions trois cent mille Ariary quatre cent huit", $numberToLetter->convertNumberToLetter(9300000.408, 'Ariary'));
        $this->assertEquals("one hundred ninety nine thousand nine hundred Ariary", $numberToLetter->convertNumberToLetter(199900, 'Ariary', 'en'));
        $this->assertEquals("nineteen thousand nine hundred ninety two", $numberToLetter->convertNumberToLetter(19992, '', 'en'));
    }
}
