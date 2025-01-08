<?php

declare(strict_types=1);

namespace Simplemediacode\TeamHouse\Tax\EuVat\Validators;

final class NorwayVatValidator implements CountryVatValidatorInterface
{
    public function validate(string $vatNumber): bool
    {
        if (!preg_match('/^\d{9}MVA$/', $vatNumber)) {
            return false;
        }


        $digits = substr($vatNumber, 0, 9);
        $weights = [2, 3, 4, 5, 6, 7];
        $sum = 0;

        for ($i = 0; $i < 8; $i++) {
            $sum += (int)$digits[$i] * $weights[$i % count($weights)];
        }

        $remainder = $sum % 11;
        $checksum = 11 - $remainder;

        if ($checksum === 11) {
            $checksum = 0;
        } elseif ($checksum === 10) {
            return false;
        }
        
        return (int)$digits[8] === $checksum;
    }
}
