<?php

namespace SaasReady\Tests\Unit\Helpers;

use DivisionByZeroError;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Helpers\Money;
use SaasReady\Models\Currency;
use SaasReady\Tests\TestCase;

class MoneyTest extends TestCase
{
    public function testInitializeMoney()
    {
        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);

        $this->assertSame(100, $money->amount);
        $this->assertSame(CurrencyCode::VIETNAMESE_DONG, $money->currencyCode);
    }

    public function testInitializeMoneyFromRealAmount()
    {
        $money = Money::makeFromRealAmount(5.99, CurrencyCode::UNITED_STATES_DOLLAR);

        $this->assertSame(599, $money->amount);
        $this->assertSame(CurrencyCode::UNITED_STATES_DOLLAR, $money->currencyCode);
    }

    public function testCloneCreatesANewInstance()
    {
        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);

        $clonedMoney = $money->clone();

        $this->assertSame($money, $money);
        $this->assertNotSame($money, $clonedMoney);
    }

    public function testMoneyAddsAnotherMoney()
    {
        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);
        $plusMoney = $money->clone(500);

        $addedMoney = $money->add($plusMoney);

        $this->assertNotSame($money, $addedMoney);
        $this->assertSame(600, $addedMoney->amount);
    }

    public function testMoneySubtractsAnotherMoney()
    {
        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);
        $subMoney = $money->clone(20);

        $subbedMoney = $money->subtract($subMoney);

        $this->assertNotSame($money, $subbedMoney);
        $this->assertSame(80, $subbedMoney->amount);
    }

    public function testMoneyMultipliesANumber()
    {
        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);

        $multipliedMoney = $money->multiply(2.5);

        $this->assertNotSame($money, $multipliedMoney);
        $this->assertSame(250, $multipliedMoney->amount);
    }

    public function testMoneyDividesANumber()
    {
        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);

        $dividedMoney = $money->divide(2);

        $this->assertNotSame($money, $dividedMoney);
        $this->assertSame(50, $dividedMoney->amount);
    }

    public function testMoneyDividesByZeroGotError()
    {
        $this->expectException(DivisionByZeroError::class);

        $money = Money::make(100, CurrencyCode::VIETNAMESE_DONG);

        $money->divide(0);
    }

    public function testPresentMoneyWithSymbol()
    {
        Currency::factory()->create([
            'code' => CurrencyCode::UNITED_STATES_DOLLAR,
            'space_after_symbol' => true,
            'symbol' => '$',
            'decimal_separator' => '.',
            'thousands_separator' => ',',
            'decimals' => 2,
        ]);

        $money = Money::make(100, CurrencyCode::UNITED_STATES_DOLLAR);
        $presentedWithDecimals = $money->present(true, true);
        $presentedWithoutDecimals = $money->present(true, false);

        $this->assertSame('$ 1.00', $presentedWithDecimals);
        $this->assertSame('$ 1', $presentedWithoutDecimals);
    }

    public function testPresentMoneyWithoutSymbol()
    {
        Currency::factory()->create([
            'code' => CurrencyCode::UNITED_STATES_DOLLAR,
            'space_after_symbol' => true,
            'symbol' => '$',
            'decimal_separator' => '.',
            'thousands_separator' => ',',
            'decimals' => 2,
        ]);

        $money = Money::make(1_500_00, CurrencyCode::UNITED_STATES_DOLLAR);
        $presentedWithDecimals = $money->present(false, true);
        $presentedWithoutDecimals = $money->present(false, false);

        $this->assertSame('USD 1,500.00', $presentedWithDecimals);
        $this->assertSame('USD 1,500', $presentedWithoutDecimals);
    }
}
