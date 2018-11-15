<?php

declare(strict_types = 1);

namespace Service\Sorting;

interface ISorter
{
    public function sortIt(array $content);
}
