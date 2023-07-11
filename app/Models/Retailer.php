<?php

namespace App\Models;

use App\Clients\ClientFactory;
use App\Clients\ClientInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Retailer extends Model
{
    use HasFactory;

    public function addStock(Product $product, Stock $stock): void
    {
        $stock->product_id = $product->id;
        $this->stock()->save($stock);
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function client(): ClientInterface
    {
        return (new ClientFactory())->make($this);
    }
}
