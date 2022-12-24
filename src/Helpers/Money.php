<?php

namespace SaasReady\Helpers;

use DivisionByZeroError;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Models\Currency;

/**
 * Immutable Money class to store the money information
 *
 * @note $amount is storing as cents, by default you would need to do *100 for every real amount
 * or use self@makeFromRealAmount method to do that.
 */
final class Money
{
    public function __construct(
        public readonly int $amount,
        public readonly CurrencyCode $currencyCode
    ) {
    }

    public static function make(int $amount, CurrencyCode $currencyCode): self
    {
        return new Money($amount, $currencyCode);
    }

    public static function makeFromRealAmount(float $amount, CurrencyCode $currencyCode): self
    {
        return new Money($amount * 100, $currencyCode);
    }

    public function clone(?int $amount = null): self
    {
        return self::make($amount ?? $this->amount, $this->currencyCode);
    }

    public function getCurrency(): Currency
    {
        return Currency::findByCode($this->currencyCode);
    }

    public function add(Money $money): Money
    {
        return $this->clone(
            $this->amount + $money->amount
        );
    }

    public function subtract(Money $money): Money
    {
        return $this->clone(
            $this->amount - $money->amount
        );
    }

    public function multiply(float $rate): Money
    {
        return $this->clone(
            $this->amount * $rate
        );
    }

    public function divide(float $rate): Money
    {
        if ($rate == 0) {
            throw new DivisionByZeroError();
        }

        return $this->clone(
            $this->amount / $rate
        );
    }

    /**
     * With symbol: $1234.56
     * Without symbol: USD 1234.56
     *
     * With decimals: 1234.56
     * Without decimals: 1234
     */
    public function present(bool $withSymbol = true, bool $withDecimals = true): string
    {
        $presentedAmount = $this->presentAmountOnly($withDecimals);

        if ($withSymbol) {
            $currency = $this->getCurrency();

            return sprintf(
                '%s%s%s',
                $currency->symbol,
                $currency->space_after_symbol ? ' ' : '',
                $presentedAmount
            );
        }

        return $this->currencyCode->value . ' ' . $presentedAmount;
    }

    /**
     * Present the amount only - based on the configuration from Currency
     *
     * Eg: 1,234.56
     */
    public function presentAmountOnly(bool $withDecimals = true): string
    {
        $currency = $this->getCurrency();

        return number_format(
            $this->amount / 100,
            $withDecimals ? $currency->decimals : 0,
            $currency->decimal_separator,
            $currency->thousands_separator
        );
    }
}
