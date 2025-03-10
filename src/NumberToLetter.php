<?php

namespace Mitantsoa\NumberToLetter;

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

    private static array $unitsEn = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine'
    ];

    private static array $tensEn = [
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety'
    ];

    private static array $comma = [
        1 => 'tenths',
        2 => 'hundredths',
        3 => 'thousandths',
        4 => 'ten-thousandths',
        5 => 'hundred-thousandths',
        6 => 'millionths',
        7 => 'ten-millionths',
        8 => 'hundred-millionths',
        9 => 'billionths',
        10 => 'ten-billionths',
        11 => 'hundred-billionths',
        12 => 'trillionths'
    ];

    private function convert(int $number, string $devise, string $lang): string
    {
        if ($lang)
            $lang = strtolower($lang);
        if ($lang == 'fr' || $lang == '') {
            $minus = 'moins ';
            $tooLarge = 'Nombre trop grand';
            $units = self::$units;
            $tens = self::$tens;
        } elseif ($lang == 'en') {
            $minus = 'minus ';
            $units = self::$unitsEn;
            $tens = self::$tensEn;
            $tooLarge = 'number too large';
        } else {
            return "$lang unknown";
        }

        if ($number < 0) {
            return $minus . $this->convert(-$number, $devise, $lang);
        }

        if ($number < 10) {
            return $units[$number];
        }

        if ($number < 20) {
            return $tens[$number];
        }

        if ($number < 100) {
            $decimal = (int) ($number / 10) * 10;
            $unite = $number % 10;

            if ($unite === 0) {
                return $tens[$decimal];
            }

            if (($decimal === 70 || $decimal === 90) && $lang == 'fr') {
                return $tens[$decimal - 10] . " " . $tens[10 + $unite];
            }
            return $tens[$decimal] . " " . $units[$unite];
        }

        if ($number < 1000) {
            $centaine = (int) ($number / 100);
            $remainder = $number % 100;

            if ($lang == 'fr')
                $hundredText = $centaine == 1 ? "cent" : $units[$centaine] . " cent";
            else if ($lang == "en") {
                $hundredText =  $units[$centaine] . " hundred";
            }
            if ($remainder === 0) {
                return $hundredText;
            }

            return $hundredText . " " . self::convert($remainder, $devise, $lang);
        }

        if ($number < 1000000) {
            $thousands = (int) ($number / 1000);
            $remainder = $number % 1000;

            $thousandText =  $thousands == 1 ? "mille" : self::convert($thousands, $devise, $lang) . " mille";

            if ($lang == 'fr')
                $thousandText =  $thousands == 1 ? "mille" : self::convert($thousands, $devise, $lang) . " mille";
            else if ($lang == "en") {
                $thousandText =  self::convert($thousands, $devise, $lang) . " thousand";
            }

            if ($remainder === 0) {
                return $thousandText;
            }

            return $thousandText . " " . self::convert($remainder, $devise, $lang);
        }

        if ($number < 1000000000) {
            $millier = (int) ($number / 1000000);
            $remainder = $number % 1000000;


            if ($lang == 'fr')
                $millierText =  $millier == 1 ? "Un million" : self::convert($millier, $devise, $lang) . " millions";
            else if ($lang == "en") {
                $millierText = self::convert($millier, $devise, $lang) . " million";
            }

            if ($remainder === 0) {
                return $millierText;
            }

            return $millierText . " " . self::convert($remainder, $devise, $lang);
        }

        if ($number < 1000000000000) {
            $milliard = (int) ($number / 1000000000);
            $remainder = $number % 1000000000;

            if ($lang == 'fr')
                $milliardText =  $milliard == 1 ? "Un milliard" : self::convert($milliard, $devise, $lang) . " milliards";
            elseif ($lang == 'en')
                $milliardText = self::convert($milliard, $devise, $lang) . " billion";

            if ($remainder === 0) {
                return $milliardText;
            }

            return $milliardText . " " . self::convert($remainder, $devise, $lang);
        }

        return $tooLarge;
    }

    private function countLeadingZeros(string $number): int
    {
        preg_match('/^0+/', $number, $matches);
        return isset($matches[0]) ? strlen($matches[0]) : 0;
    }

    private function countLeadingDecimal(string $number): int
    {
        $nbr = explode('.', $number);

        $nombreDec = 0;
        if (isset($nbr[0]))
            $nombreDec = strlen($nbr[0]);

        return $nombreDec;
    }

    private function convertDecimal(string $number, $devise = '', $lang = 'fr')
    {
        $text = '';
        $zeros = $this->countLeadingZeros($number);
        for ($i = 0; $i < $zeros; $i++) {
            $text .= "zéro ";
        }

        $text .= $this->convert((int) $number, $devise, $lang);
        return $text;
    }
    private function convertDecimalEn(string $number, $devise = '', $lang = 'fr')
    {
        $count = 1;
        $text = '';
        $zeros = $this->countLeadingDecimal($number);

        // for ($i = 0; $i < $zeros; $i++) {
        //     $count++;
        //     // $text .= "zéro ";
        // }

        $text .= 'and ' . $this->convert((int) $number, $devise, $lang);
        return $text . ' ' . self::$comma[$zeros];
    }

    public function convertNumberToLetter(float $number, string $devise = '', $lang = 'fr')
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
            return trim($this->convert($floor, '', $lang) . " " . $devise);
        }
        if ($lang == 'fr')
            return trim($this->convert($floor, '', $lang) . " " . $devise . " " . $this->convertDecimal($decimal, $devise, $lang));
        elseif ($lang == 'en')
            return trim($this->convert($floor, '', $lang)  . " " . $this->convertDecimalEn($decimal, $devise, $lang) . " " . $devise);
    }
}
