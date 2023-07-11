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
        $status = $this->retailer
            ->client()
            ->checkAvailability($this);

        // And then refresh the current stock record.
        $this->update([
            'in_stock' => $status->available,
            'price'    => $status->price,
        ]);
    }

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }


}
