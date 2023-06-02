<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
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
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

        // Fake the request to the API Retailer endpoint
        \Http::fake(static fn () => ['available' => true, 'price' => 2990]);

        // When
        // I trigger the php artisan track command
        // And assuming the stock is available now
        $this->artisan('track')
            ->expectsOutput('All done!');

        // Then
        // The stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }
}
