<?php

namespace App\Clients;

class StockStatus
{

    public function __construct(public $available, public $price)
    {
    }
}
