<?php namespace Shohabbos\Stores\Models;

use Model;

/**
 * Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_stores_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = ['positions'];

    public $belongsTo = [
        'store' => Store::class,
        'user' => \RainLab\User\Models\User::class,
        'position' => \Lovata\OrdersShopaholic\Models\OrderPosition::class,
        'order' => \Lovata\OrdersShopaholic\Models\Order::class
    ];

    protected $guarded = ['id'];

    public function getPositionsCollectionAttribute() {
        return \Lovata\OrdersShopaholic\Models\OrderPosition::whereIn('id', $this->positions)->get();
    }

}
