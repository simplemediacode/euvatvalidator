<?php

declare(strict_types=1);

namespace Simplemediacode\TeamHouse\Tax\EuVat\Validators;

interface CountryVatValidatorInterface
{
    public function validate(string $vatNumber): bool;
}