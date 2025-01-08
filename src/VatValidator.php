<?php

declare(strict_types=1);

namespace Simplemediacode\TeamHouse\Tax\EuVat;

use Simplemediacode\TeamHouse\Tax\EuVat\Validators\CountryVatValidatorInterface;
use Simplemediacode\TeamHouse\Tax\EuVat\Validators\NorwayVatValidator;
use Simplemediacode\TeamHouse\Tax\EuVat\Validators\GeneralVatValidator;

final class VatValidator
{
    private static array $validators = [
        'NO' => NorwayVatValidator::class,
    ];

    private static array $patterns = [
        'AT' => ['regex' => '/^U\d{8}$/', 'description' => 'Austria'],
        'BE' => ['regex' => '/^0?\d{9,10}$/', 'description' => 'Belgium'],
        'BG' => ['regex' => '/^\d{9,10}$/', 'description' => 'Bulgaria'],
        'HR' => ['regex' => '/^\d{11}$/', 'description' => 'Croatia'],
        'CY' => ['regex' => '/^\d{8}[A-Z]$/', 'description' => 'Cyprus'],
        'CZ' => ['regex' => '/^\d{8,10}$/', 'description' => 'Czech Republic'],
        'DK' => ['regex' => '/^\d{8}$/', 'description' => 'Denmark'],
        'EE' => ['regex' => '/^\d{9}$/', 'description' => 'Estonia'],
        'FI' => ['regex' => '/^\d{8}$/', 'description' => 'Finland'],
        'FR' => ['regex' => '/^FR([0-9]{2}|[A-HJ-NP-Z]{1}[A-Z]{1})\d{9}$/', 'description' => 'France'],
        'DE' => ['regex' => '/^\d{9}$/', 'description' => 'Germany'],
        'EL' => ['regex' => '/^\d{9}$/', 'description' => 'Greece'],
        'HU' => ['regex' => '/^\d{8}$/', 'description' => 'Hungary'],
        'IE' => ['regex' => '/^\d{7}[A-Z]{1,2}$/', 'description' => 'Ireland'],
        'IT' => ['regex' => '/^\d{11}$/', 'description' => 'Italy'],
        'LV' => ['regex' => '/^LV\d{11}$/', 'description' => 'Latvia'],
        'LT' => ['regex' => '/^\d{9}$|^\d{12}$/', 'description' => 'Lithuania'],
        'LU' => ['regex' => '/^\d{8}$/', 'description' => 'Luxembourg'],
        'MT' => ['regex' => '/^\d{8}$/', 'description' => 'Malta'],
        'NL' => ['regex' => '/^\d{9}B\d{2}$/', 'description' => 'Netherlands'],
        'NO' => ['regex' => '/^\d{9}MVA$/', 'description' => 'Norway (non-EU)'],
        'PL' => ['regex' => '/^\d{10}$/', 'description' => 'Poland'],
        'PT' => ['regex' => '/^\d{9}$/', 'description' => 'Portugal'],
        'RO' => ['regex' => '/^\d{2,10}$/', 'description' => 'Romania'],
        'SK' => ['regex' => '/^\d{10}$/', 'description' => 'Slovakia'],
        'SI' => ['regex' => '/^\d{8}$/', 'description' => 'Slovenia'],
        'ES' => ['regex' => '/^[A-Z]?\d{7}[A-Z]?$/', 'description' => 'Spain'],
        'SE' => ['regex' => '/^\d{12}$/', 'description' => 'Sweden'],
        'CHE' => ['regex' => '/^CHE[-]?\d{3}\.\d{3}\.\d{3}\s?(MWST|TVA|IVA)$/', 'description' => 'Switzerland (non-EU)'],
        'GB' => ['regex' => '/^\d{9}$/', 'description' => 'United Kingdom (non-EU)'],
    ];

    public static function validateVatForCountry(string $vatNumber, string $countryCode): bool
    {

        if (!isset(self::$patterns[$countryCode])) {
            throw new \InvalidArgumentException("Invalid country code: $countryCode");
        }

        $validator = self::getValidator($countryCode);

        return $validator->validate($vatNumber);
    }

    private static function getValidator(string $countryCode): CountryVatValidatorInterface
    {
        if (isset(self::$validators[$countryCode])) {
            return new self::$validators[$countryCode]();
        }

        return new GeneralVatValidator(self::$patterns[$countryCode]['regex']);
    }
}
