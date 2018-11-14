<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\Card;
use Service\Billing\IBilling;
use Service\Communication\Email;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\Discount\NullObject;
use Service\User\ISecurity;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Service\Builder\BasketBuilder;

class Basket
{
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';

    /**
     * @property SessionInterface $session
     */
    private $session;

    /**
     * @property BasketBuilder $builder
     */
    private $builder;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session, BasketBuilder $builder = null)
    {
        $this->session = $session;
        $this->builder = $builder;
    }

    /**
     * Добавляем товар в заказ
     *
     * @param int $product
     *
     * @return void
     */
    public function addProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($product, $basket, true)) {
            $basket[] = $product;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     *
     * @param int $productId
     *
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     *
     * @return Model\Entity\Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();
        return $this->getProductRepository()->search($productIds);
    }

    /**
     * Оформление заказа
     *
     * @return void
     */
    public function getBasketBuilder(): BasketBuilder
    {
        $builder = $this->builder;

        $builder->setProducts($this->getProductsInfo());

        // Здесь должна быть некоторая логика выбора способа платежа
        // by default `new Card()`
        $builder->setBilling();

        // Здесь должна быть некоторая логика получения информации о скидки пользователя
        // by default `new NullObject()`
        $builder->setDiscounting();

        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        // by default `new Email()`
        $builder->setCommunication();

        $builder->setUsersSecurity(new Security($this->session));

        return $builder;
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }

    /**
     * Получаем список id товаров корзины
     *
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }
}
