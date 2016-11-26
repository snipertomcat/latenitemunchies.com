<?php

/**
 * App\OrderItemMetaCollection
 *
 * @author Jesse Griffin <hemham914@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Collection;

class OrderItemMetaCollection extends Collection
{
    protected $changedKeys = [];

    /**
     * Search for the desired key and return only the row that represent it
     *
     * @param string $key
     * @return string
     */
    public function __get($key)
    {
        foreach ($this->items as $item) {
            if ($item->meta_key == $key) {
                return $item->value;
            }
        }
    }

    public function __set($key, $value)
    {
        $this->changedKeys[] = $key;

        foreach ($this->items as $item) {
            if ($item->meta_key == $key) {
                $item->meta_value = $value;

                return;
            }
        }

        $item = new OrderItemMeta([
            'meta_key' => $key,
            'meta_value' => $value,
        ]);

        $this->push($item);
    }

    public function save($orderItemId)
    {
        $this->each(function ($item) use ($orderItemId) {
            if (in_array($item->meta_key, $this->changedKeys)) {
                $item->order_item_id = $orderItemId;
                $item->save();
            }
        });
    }
}
