<?php

declare(strict_types = 1);

namespace Service\Builder;

use Service\Billing\IBilling;
use Service\Billing\Card;
use Service\Communication\ICommunication;
use Service\Communication\Email;
use Service\Discount\IDiscount;
use Service\User\ISecurity;
use Model\Entity\Product;
use Service\Discount\NullObject;
use Service\Builder\Exception\BuilderException;

/**
 * BasketBuilder - Concrete builder for Basket
 *
 */
class BasketBuilder implements IBuilder
{
    /**
     * @property BasketBuilder $builder
     */
    protected $builder;

    /**
     *
     * @property Product[] $products
     */
    protected $products;

    /**
     *
     * @property IBilling $payment
     */
    protected $payment;

    /**
     *
     * @property ICommunication $communicator
     */
    protected $communicator;

    /**
     *
     * @property ISecurity $session
     */
    protected $session;

    /**
     * @property IDiscount $discounter
     */
    protected $discounter;

    /**
     * Set property builder
     *
     */
    protected function reset(): void
    {
        $this->builder = new static();
    }

    /**
     * Set property $products
     *
     * @see \Service\Builder\IBuilder::setProducts()
     */
    public function setProducts(array $products): IBuilder
    {
        $this->reset();
        $this->builder->products = $products;

        return $this;
    }

    /**
     * Set property $payment
     *
     * @see \Service\Builder\IBuilder::setBilling()
     */
    public function setBilling(IBilling $payment = null): IBuilder
    {

        $this->builder->payment = $payment ?? new Card();

        return $this;
    }

    /**
     * Set property $communicator
     *
     * @see \Service\Builder\IBuilder::setCommunication()
     */
    public function setCommunication(ICommunication $communicator = null): IBuilder
    {
        $this->builder->communicator = $communicator ?? new Email();

        return $this;
    }

    /**
     * Set property $session
     *
     * @see \Service\Builder\IBuilder::setUsersSecurity()
     */
    public function setUsersSecurity(ISecurity $session): IBuilder
    {
        $this->builder->session = $session;

        if (empty($this->builder->session)) {
            return new BuilderException('The session must be setting.');
        }

        return $this;
    }

    /**
     * Set property $discounter
     *
     * @see \Service\Builder\IBuilder::setDiscounting()
     */
    public function setDiscounting(IDiscount $discounter = null): IBuilder
    {
        $this->builder->discounter = $discounter ?? new NullObject();

        return $this;
    }

    /**
     * Get property $products
     *
     * @see \Service\Builder\IBuilder::getProducts()
     */
    public function getProducts(): array
    {
        return $this->builder->products;
    }

    /**
     * Get property $payment
     *
     * @see \Service\Builder\IBuilder::setBilling()
     */
    public function getBilling(): IBilling
    {
         return $this->builder->payment;
    }

    /**
     * Get property $communicator
     *
     * @see \Service\Builder\IBuilder::setCommunication()
     */
    public function getCommunication(): ICommunication
    {
        return $this->builder->communicator;
    }

    /**
     * Get property $session
     *
     * @see \Service\Builder\IBuilder::getUsersSecurity()
     */
    public function getUsersSecurity(): ISecurity
    {
         return $this->builder->session;
    }

    /**
     * Get property $discounter
     *
     * @see \Service\Builder\IBuilder::getDiscounting()
     */
    public function getDiscounting(): IDiscount
    {

        return $this->builder->discounter;
    }

    public function getBuilder(): BasketBuilder
    {
        return $this->builder;
    }
}
