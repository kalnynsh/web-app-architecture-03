<?php

declare(strict_types = 1);

namespace Service\Sorting;

class NameSorter implements ISorter
{
    public function sortIt(array $products)
    {
        /* @var Model\Entity\Product[] $products */
        $names = [];

        foreach ($products as $key => $row) {
            $rowArray = $row->toArray();
            $names[] = $rowArray['name'];
        }

        \array_multisort($names, SORT_ASC, SORT_LOCALE_STRING, $products);

        return $products;
    }
}
