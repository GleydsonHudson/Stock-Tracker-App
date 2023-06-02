<?php

namespace Tests\Feature;

 use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_checks_stocks_for_products_at_retailers(): void
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 10000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => true,
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertTrue($switch->inStock());

    }
}
