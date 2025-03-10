<?php

// namespace Mitantsoa\NumberToLetter;
namespace App;

class NumberToLetter
{

    private static array $units = [
        0 => 'zéro',
        1 => 'un',
        2 => 'deux',
        3 => 'trois',
        4 => 'quatre',
        5 => 'cinq',
        6 => 'six',
        7 => 'sept',
        8 => 'huit',
        9 => 'neuf'
    ];

    private static array $tens = [
        10 => 'dix',
        11 => 'onze',
        12 => 'douze',
        13 => 'treize',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'seize',
        17 => 'dix sept',
        18 => 'dix huit',
        19 => 'dix neuf',
        20 => 'vingt',
        30 => 'trente',
        40 => 'quarante',
        50 => 'cinquante',
        60 => 'soixante',
        70 => 'soixante dix',
        80 => 'quatre vingt',
        90 => 'quatre vingt dix'
    ];

    private function convert(int $number): string
    {

        if ($number < 0) {
            return "moins " . $this->convert(-$number);
        }

        if ($number < 10) {
            return self::$units[$number];
        }

        if ($number < 20) {
            return self::$tens[$number];
        }

        if ($number < 100) {
            $decimal = (int) ($number / 10) * 10;
            $unite = $number % 10;

            if ($unite === 0) {
                return self::$tens[$decimal];
            }

            if ($decimal === 70 || $decimal === 90) {
                return self::$tens[$decimal - 10] . " " . self::$tens[10 + $unite];
            }
            return self::$tens[$decimal] . " " . self::$units[$unite];
        }

        if ($number < 1000) {
            $centaine = (int) ($number / 100);
            $remainder = $number % 100;

            $hundredText = $centaine == 1 ? "cent" : self::$units[$centaine] . " cent";

            if ($remainder === 0) {
                return $hundredText;
            }

            return $hundredText . " " . self::convert($remainder);
        }

        if ($number < 1000000) {
            $thousands = (int) ($number / 1000);
            $remainder = $number % 1000;

            $thousandText =  $thousands == 1 ? "mille" : self::convert($thousands) . " mille";

            if ($remainder === 0) {
                return $thousandText;
            }

            return $thousandText . " " . self::convert($remainder);
        }

        if ($number < 1000000000) {
            $millier = (int) ($number / 1000000);
            $remainder = $number % 1000000;

            $millierText =  $millier == 1 ? "Un million" : self::convert($millier) . " millions";

            if ($remainder === 0) {
                return $millierText;
            }

            return $millierText . " " . self::convert($remainder);
        }

        if ($number < 1000000000000) {
            $milliard = (int) ($number / 1000000000);
            $remainder = $number % 1000000000;

            $milliardText =  $milliard == 1 ? "Un milliard" : self::convert($milliard) . " milliards";

            if ($remainder === 0) {
                return $milliardText;
            }

            return $milliardText . " " . self::convert($remainder);
        }

        return "Nombre trop grand";
    }

    private function countLeadingZeros(string $number): int
    {
        preg_match('/^0+/', $number, $matches);
        return isset($matches[0]) ? strlen($matches[0]) : 0;
    }

    private function convertDecimal(string $number)
    {
        $text = '';
        $zeros = $this->countLeadingZeros($number);

        for ($i = 0; $i < $zeros; $i++) {
            $text .= "zéro ";
        }

        $text .= $this->convert((int) $number);
        return $text;
    }

    public function convertNumberToLetter(float $number, string $devise = '')
    {
        $floor = floor($number);

        $decimalPart = explode('.', (string) $number);
        $decimalPrecision = trim(isset($decimalPart[1]) ? strlen($decimalPart[1]) : 0, 0);

        $decimal = round($number - $floor, (int)$decimalPrecision);

        $valueDecimal = explode('.', (string) $decimal);

        $decimal = 0;
        if (count($valueDecimal) > 1) {
            $decimal = $valueDecimal[1];
        }

        $dec = (int) $decimal;

        if ($dec != 0 && $devise === "") {
            return 'devise manquante';
        }

        if ($dec == 0) {
            return trim($this->convert($floor) . " " . $devise);
        }
        return trim($this->convert($floor) . " " . $devise . " " . $this->convertDecimal($decimal));
    }
}
