<?php
/**
 * Created by: Jesse Griffin
 * Date: 11/26/2016
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Corcel\Acf\AdvancedCustomFields;
use Corcel\Traits\CreatedAtTrait;
use Corcel\Traits\UpdatedAtTrait;
use Illuminate\Support\Facades\Broadcast;
use Thunder\Shortcode\ShortcodeFacade;

class OrderItem extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;

    protected $connection = 'wordpress';

    protected static $postTypes = [];
    protected static $shortcodes = [];

    protected $table = 'woocommerce_order_items';
    protected $primaryKey = 'order_item_id';
    protected $with = ['meta'];

    protected $fillable = [
        'order_item_name',
        'order_item_type',
        'order_id'
    ];

    public function __construct(array $attributes = [])
    {
        foreach ($this->fillable as $field) {
            if (!isset($attributes[$field])) {
                $attributes[$field] = '';
            }
        }

        parent::__construct($attributes);
    }

    /**
     * Meta data relationship.
     *
     * @return Corcel\PostMetaCollection
     */
    public function meta()
    {
        return $this->hasMany('App\OrderItemMeta', 'order_item_id');
    }
}