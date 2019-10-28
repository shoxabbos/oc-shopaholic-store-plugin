<?php namespace Shohabbos\Stores\Models;

use Model;

/**
 * Model
 */
class Banner extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_stores_banners';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $attachOne = [
        'image' => 'System\Models\File',
    ];
    
    public $belongsTo = [
        'banner' => Banner::class
    ];
}
