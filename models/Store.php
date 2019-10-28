<?php namespace Shohabbos\Stores\Models;

use Model;

/**
 * Model
 */
class Store extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_stores_stores';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'user' => \RainLab\User\Models\User::class
    ];

    public $attachOne = [
        'logo' => 'System\Models\File',
        'header_image' => 'System\Models\File',
    ];
	
    public $hasMany = [
        'products' => 'Lovata\Shopaholic\Models\Product',
        'banners'  => 'Shohabbos\Stores\Models\Banner',
    ];

}
