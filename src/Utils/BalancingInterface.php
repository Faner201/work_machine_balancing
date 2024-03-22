<?php

namespace App\Utils;

interface BalancingInterface
{
    public function rebalanced(string $typeRebalanced): string;
}