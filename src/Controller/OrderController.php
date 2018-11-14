<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Service\Builder\BasketBuilder;
use Service\Process\Checkout;

class OrderController
{
    use Render;

    /**
     * Корзина
     *
     * @param Request $request
     * @return Response
     */
    public function infoAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            return $this->redirect('order_checkout');
        }

        $session = $request->getSession();
        $busket = $this->getBasket($session);
        $productList = $busket->getProductsInfo();
        $isLogged = (new Security($session))->isLogged();

        return $this->render('order/info.html.php', ['productList' => $productList, 'isLogged' => $isLogged]);
    }

    /**
     * Оформление заказа
     *
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Request $request): Response
    {
        $session = $request->getSession();
        $isLogged = (new Security($session))->isLogged();

        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        $basket = $this->getBasket($session);
        $basketBuilder = $basket->getBasketBuilder();
        $this->checkout($basketBuilder);

        return $this->render('order/checkout.html.php');
    }

    public function getBuilder(): BasketBuilder
    {
        return new BasketBuilder();
    }

    public function getBasket($session): Basket
    {
        $builder = $this->getBuilder();
        return new Basket($session, $builder);
    }

    public function checkout(BasketBuilder $basketBuilder): void
    {
        (new Checkout($basketBuilder))->process();
    }
}
