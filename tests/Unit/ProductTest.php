<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_checks_stocks_for_products_at_retailers(): void
    {
        $product = Product::create(['name' => 'Nintendo Switch']);

        $retailer = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($product->inStock());

        $stock = new Stock([
            'price' => 10000,
            'url' => 'https://foo.com',
            'sku' => '12345',
            'in_stock' => true,
        ]);

        $retailer->addStock($product, $stock);

        $this->assertTrue($product->inStock());

    }
}
