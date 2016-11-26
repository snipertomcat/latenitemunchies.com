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

class OrderItemMeta extends Model
{
    protected $connection = 'wordpress';

    protected $table = 'woocommerce_order_itemmeta';
    protected $primaryKey = 'meta_id';
    public $timestamps = false;
    protected $fillable = [
        'meta_key',
        'meta_value',
        'order_item_id'
    ];

    /**
     * OrderItem relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItem($ref = false)
    {
        if ($ref) {
            $this->primaryKey = 'meta_value';

            return $this->hasOne('App\OrderItem', 'order_item_id');
        }

        return $this->belongsTo('App\OrderItem');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['value'];

    /**
     * Gets the value.
     * Tries to unserialize the object and returns the value if that doesn't work.
     *
     * @return value
     */
    public function getValueAttribute()
    {
        try {
            $value = unserialize($this->meta_value);
            // if we get false, but the original value is not false then something has gone wrong.
            // return the meta_value as is instead of unserializing
            // added this to handle cases where unserialize doesn't throw an error that is catchable
            return $value === false && $this->meta_value !== false ? $this->meta_value : $value;
        } catch (Exception $ex) {
            return $this->meta_value;
        }
    }

    /**
     * Taxonomy relationship from the meta_value.
     * @param  string $key
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function taxonomy($primary = null, $where = null)
    {
        // possible to exclude a relationship connection
        if (!is_null($primary) && !empty($primary)) {
            $this->primaryKey = $primary;
        }

        // load relationship
        $relation = $this->hasOne('Corcel\TermTaxonomy', 'term_taxonomy_id');

        // do we need to filter which value to look for with meta_value
        // if (!is_null($where) && !empty($where)) {
        //     $relation->where($where, $this->meta_value);
        // }

        return $relation;
    }

    /**
     * Override newCollection() to return a custom collection
     * @param array $models
     * @return \Corcel\PostMetaCollection
     */
    public function newCollection(array $models = [])
    {
        return new OrderItemMetaCollection($models);
    }
}