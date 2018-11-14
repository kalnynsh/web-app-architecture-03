<?php

declare(strict_types = 1);

namespace Service\Process;

use Service\Builder\IBuilder;

/**
 * class Checkout - checkout Basket with Product
 *
 */
class Checkout
{
    /**
     * @property IBuilder $builder
     */
    protected $builder;

    public function __construct(IBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function process(): void
    {
        /**
         * @var float
         */
        $totalPrice = 0;

        foreach ($this->builder->getProducts() as $product) {
            $totalPrice += $product->getPrice();
        }

        $discounter = $this->builder->getDiscounting();
        $discount = $discounter->getDiscount();
        $finalPrice = $totalPrice - ($totalPrice / 100) * $discount;

        $billing = $this->builder->getBilling();
        $billing->pay($finalPrice);

        $security = $this->builder->getUsersSecurity();
        $user = $security->getUser();

        $communication = $this->builder->getCommunication();
        $communication->process($user, 'checkout/email.html.php');
    }
}
