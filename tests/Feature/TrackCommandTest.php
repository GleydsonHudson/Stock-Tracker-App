<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function it_tracks_product_stock(): void
    {
        // Given
        // I have a product with stock
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price'    => 10000,
            'url'      => 'http://foo.com',
            'sku'      => '12345',
            'in_stock' => false,
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertFalse($stock->fresh()->in_stock);

        \Http::fake(static function () {
            return [
                'available' => true,
                'price'     => 2990,
            ];
        });

        // When
        // I trigger the php artisan track command
        // And assuming the stock is available now
        $this->artisan('track');

        // Then
        // The stock details should be refreshed
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
