<?php

declare(strict_types=1);

namespace App\Clients;
use App\Models\Stock;

class BestBuy implements ClientInterface
{

    public function checkAvailability(Stock $stock): StockStatus
    {
        $result =  \Http::get('http://foo.test')->json();

        return new StockStatus(
            $result['available'],
            $result['price']
        );
    }
}
