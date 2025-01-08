<?php

declare(strict_types=1);

namespace Simplemediacode\TeamHouse\Tax\EuVat\Validators;

final class GeneralVatValidator implements CountryVatValidatorInterface
{
    private string $regex;

    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    public function validate(string $vatNumber): bool
    {

        return preg_match($this->regex, $vatNumber) === 1;
    }
}
