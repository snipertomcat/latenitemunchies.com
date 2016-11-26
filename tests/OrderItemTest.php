<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\OrderItem;

class OrderItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOrderItemsTableNotEmpty()
    {
        $orderItems = App\OrderItem::find(1);
        $this->assertNotEmpty($orderItems);
    }

    public function testRetrievalByOrderId()
    {
        $orderId = 49;
        $orderItem = App\OrderItem::where('order_id', $orderId)
                        ->orderBy('order_item_id')
                        ->get();
        $this->assertNotEmpty($orderItem);
    }
}
