<?php

namespace Service\Builder;

use Service\Billing\IBilling;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;

/**
 *
 * IBuilder interface
 *
 */
interface IBuilder
{
    public function setProducts(array $products): IBuilder;
    public function setBilling(IBilling $payment): IBuilder;
    public function setDiscounting(IDiscount $discounter): IBuilder;
    public function setCommunication(ICommunication $communicator): IBuilder;
    public function setUsersSecurity(ISecurity $session): IBuilder;

    public function getProducts(): array;
    public function getBilling(): IBilling;
    public function getDiscounting(): IDiscount;
    public function getCommunication(): ICommunication;
    public function getUsersSecurity(): ISecurity;
}
