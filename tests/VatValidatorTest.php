<?php

use PHPUnit\Framework\TestCase;
use Simplemediacode\TeamHouse\Tax\EuVat\VatValidator;

final class VatValidatorTest extends TestCase
{
    public function testValidateVatForCountryNO()
    {
        $this->assertTrue(VatValidator::validateVatForCountry('123456784MVA', 'NO')); // Example valid number
        $this->assertFalse(VatValidator::validateVatForCountry('123456784', 'NO'));
    }

    public function testValidateVatForCountryCHE()
    {
        // nestle in CHE
        $this->assertTrue(VatValidator::validateVatForCountry('CHE-116.281.710 TVA', 'CHE')); // Valid
        $this->assertTrue(VatValidator::validateVatForCountry('CHE116.281.710 TVA', 'CHE')); // Valid
        $this->assertTrue(VatValidator::validateVatForCountry('CHE116.281.710TVA', 'CHE')); // Valid
        $this->assertFalse(VatValidator::validateVatForCountry('CHE-116.281.710', 'CHE')); // Missing suffix
        $this->assertFalse(VatValidator::validateVatForCountry('116.281.710', 'CHE')); // Missing prefix
        $this->assertFalse(VatValidator::validateVatForCountry('116.281.710TVA', 'CHE')); // Missing prefix
        $this->assertFalse(VatValidator::validateVatForCountry('116.281.710 TVA', 'CHE')); // Missing prefix

    }

    public function testValidateVatForCountryFR()
    {
        $this->assertTrue(VatValidator::validateVatForCountry('FR50572093920', 'FR')); // Valid
        $this->assertTrue(VatValidator::validateVatForCountry('FR76662042449', 'FR')); // Valid
        $this->assertFalse(VatValidator::validateVatForCountry('FR-123456789', 'FR')); // Invalid check value
        $this->assertFalse(VatValidator::validateVatForCountry('50572093920', 'FR')); // Missing FR prefix
    }

    public function testValidateVatForCountryLT()
    {
        $this->assertTrue(VatValidator::validateVatForCountry('123456789012', 'LT'));
        $this->assertFalse(VatValidator::validateVatForCountry('1234567890', 'LT'));
        $this->assertFalse(VatValidator::validateVatForCountry('123456789LT', 'LT'));
    }

    public function testValidateVatForCountryLV()
    {
        $this->assertTrue(VatValidator::validateVatForCountry('LV12345678901', 'LV')); // VAT 
        $this->assertFalse(VatValidator::validateVatForCountry('12345678901', 'LV')); // Not Valid VAT, but valid ID number
        $this->assertFalse(VatValidator::validateVatForCountry('123456789', 'LV'));
    }
}
