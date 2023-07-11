<?php

namespace App\Clients;

use App\Models\Stock;

interface ClientInterface
{

    public function checkAvailability(Stock $stock): StockStatus;
}
