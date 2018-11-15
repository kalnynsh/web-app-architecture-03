<?php

declare(strict_types = 1);

namespace Service\Sorting;

class PriceSorter implements ISorter
{
    public function sortIt(array $products)
    {
        /* @var Model\Entity\Product[] $products */
        $prices = [];

        foreach ($products as $key => $row) {
            $rowArray = $row->toArray();
            $prices[] = $rowArray['price'];
        }

        \array_multisort($prices, SORT_ASC, SORT_NUMERIC, $products);

        return $products;
    }
}
