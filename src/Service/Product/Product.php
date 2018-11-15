<?php

declare(strict_types = 1);

namespace Service\Product;

use Service\Sorting\ISorter;
use Model;

class Product
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\Product|null
     */
    public function getInfo(int $id): ?Model\Entity\Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     *
     * @return Model\Entity\Product[]
     */
    public function getAll(): array
    {
        return $this->getProductRepository()->fetchAll();
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
     * Сортируем продукты
     *
     * @return Model\Entity\Product[]
     */
    public function sort(ISorter $sorter, array $products): array
    {
        $productsSorted = $sorter->sortIt($products);
        return $productsSorted;
    }
}
