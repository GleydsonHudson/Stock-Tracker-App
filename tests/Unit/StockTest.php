<?php

namespace Tests\Unit;


use App\Clients\ClientInterface;
use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use App\Clients\ClientNotFoundException;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_an_exception_if_a_client_is_not_found_when_tracking(): void
    {
        // given I have a retailer with stock
        $this->seed(RetailerWithProductSeeder::class);

        // And if the retailer doesn't have a client class
        Retailer::first()->update(['name' => 'Foo Retailer']);

        // Then an exception should be thrown
        $this->expectException(ClientNotFoundException::class);

        // If I track that stock
        Stock::first()->track();
    }

    /** @test */
    public function it_updates_local_stock_status_after_being_tracked(): void
    {
        $this->seed(RetailerWithProductSeeder::class);

        ClientFactory::shouldReceive('make->checkAvailability')
                     ->andReturn(new StockStatus($available = true, $price = 9900));

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);
    }
}
