<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity\Product as ProductEntity;

class Product
{
    /**
     * Поиск объектов Продуктов согласно переданному массиву id
     *
     * @param int[] $ids
     * @return ProductEntity[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        return $this->getProductsList($ids);
    }

    /**
     * Получаем все объекты Продуктов
     *
     * @return ProductEntity[]
     */
    public function fetchAll(): array
    {
        return $this->getProductsList();
    }

    /**
     * Получаем Продукты из источника данных
     * $search = ['id' => [2, 4]];
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [
            [
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }

    /**
     * Получаем прототип Продукта id = 1
     *
     * @return ProductEntity
     */
    private function getProto(): ProductEntity
    {
        $item = $this->getDataFromSource(['id' => [1, ]]);
        $proto = new ProductEntity($item[0]['id'], $item[0]['name'], $item[0]['price']);

        return $proto;
    }

    /**
     * Получаем массив объектов Продуктов
     *
     * @return ProductEntity[]
     */
    private function getProductsList(array $ids = []): array
    {
        $productsList = [];
        $proto = $this->getProto();

        if (!count($ids)) {
            foreach ($this->getDataFromSource() as $item) {
                $product = clone $proto;
                $product
                    ->setId($item['id'])
                    ->setName($item['name'])
                    ->setPrice($item['price']);

                $productsList[] = $product;
            }

            return $productsList;
        }

        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $product = clone $proto;
            $product
                ->setId($item['id'])
                ->setName($item['name'])
                ->setPrice($item['price']);

            $productsList[] = $product;
        }

        return $productsList;
    }
}
