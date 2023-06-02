<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean',
    ];

    public function track(): void
    {
        if ($this->retailer->name === 'Best Buy') {
            // Hit an API endpoint for the associated retailer
            // Fetch the up-to-date details for the item
            $results = \Http::get('http://foo.test')->json();

            // And then refresh the current stock record.
            $this->update([
                'in_stock' => $results['available'],
                'price' => $results['price'],
            ]);
        }
    }

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }
}
