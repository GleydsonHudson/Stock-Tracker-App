<?php

namespace App\Clients;

use App\Models\Stock;

class Target implements ClientInterface
{

    public function checkAvailability(Stock $stock): StockStatus
    {
        // TODO: Implement checkAvailability() method.
    }
}
