<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\Product\Product as ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Service\Sorting\PriceSorter;
use Service\Sorting\NameSorter;

class ProductController
{
    use Render;

    /**
     * Информация о продукте
     *
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function infoAction(Request $request, $id): Response
    {
        $basket = (new Basket($request->getSession()));

        if ($request->isMethod(Request::METHOD_POST)) {
            $basket->addProduct((int)$request->request->get('product'));
        }

        $productInfo = $this->getProductService()->getInfo((int)$id);

        if ($productInfo === null) {
            return $this->render('error404.html.php');
        }

        $isInBasket = $basket->isProductInBasket($productInfo->getId());

        return $this->render('product/info.html.php', ['productInfo' => $productInfo, 'isInBasket' => $isInBasket]);
    }

    /**
     * Список всех продуктов
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $productService = $this->getProductService();
        $productsList = $productService->getAll();

        $sortingParam = $request->query->get('sort') ?? 'name';
        $sorter = ($sortingParam === 'price') ? $this->getPriceSorter() : $this->getNameSorter();

        $productsSorted = $productService->sort($sorter, $productsList);

        return $this->render('product/list.html.php', ['productList' => $productsSorted]);
    }

    /**
     * Fabric method for getting PriceSorter object
     *
     * @return PriceSorter
     */
    protected function getPriceSorter(): PriceSorter
    {
        return new PriceSorter();
    }

    /**
     * Fabric method for getting NameSorter object
     *
     * @return NameSorter
     */
    protected function getNameSorter(): NameSorter
    {
        return new NameSorter();
    }

    /**
     * Fabric method for getting Service\Product\Product object
     *
     * @return ProductService
     */
    protected function getProductService(): ProductService
    {
        return new ProductService();
    }
}
