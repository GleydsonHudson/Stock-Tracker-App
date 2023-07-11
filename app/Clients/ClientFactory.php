<?php

declare(strict_types=1);

namespace App\Clients;

use App\Models\Retailer;
use Illuminate\Support\Str;

class ClientFactory
{

    public function make(Retailer $retailer): ClientInterface
    {
        $class = "App\\Clients\\" . Str::studly($retailer->name);

        if (! class_exists($class)){
            throw new ClientNotFoundException('ClientInterface not found for'. $retailer->name);
        }

        return new $class;
    }
}
