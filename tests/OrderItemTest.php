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
        $orderItem = new OrderItem();
        $orderId = 49;
        print_r($orderItem->findByOrderId($orderId));
        $this->assertNotEmpty($orderItem->findByOrderId($orderId));
    }
}
