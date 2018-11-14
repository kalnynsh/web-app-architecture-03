<?php

declare(strict_types = 1);

namespace Service\Billing;

use Service\Billing\Exception\BillingException;

interface IBilling
{
    /**
     * Декларация сигнатуры метода оплаты
     *
     * @param float $totalPrice
     *
     * @return void
     *
     * @throws BillingException
     */
    public function pay(float $totalPrice): void;
}
