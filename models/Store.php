<?php namespace Shohabbos\Stores\Models;

use Model;

/**
 * Model
 */
class Store extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_stores_stores';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    protected $jsonable = [
        'is_category'
    ];
    
    public $belongsTo = [
        'user' => \RainLab\User\Models\User::class,
    ];

    public $attachOne = [
        'logo' => 'System\Models\File',
        'header_image' => 'System\Models\File',
    ];
	
    public $hasMany = [
        'orders' => Order::class,
        'products' => 'Lovata\Shopaholic\Models\Product',
        'banners'  => 'Shohabbos\Stores\Models\Banner'
    ];

    /**
     * The attributes on which the store list can be ordered.
     * @var array
     */
    public static $allowedSortingOptions = [
        'title asc'         => 'Title asc',
        'title desc'        => 'Title desc',
        'random'            => 'Random'
    ];


    /**
     * Lists posts for the frontend
     *
     * @param        $query
     * @param  array $options Display options
     * @return Post
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'             => 1,
            'perPage'          => 20,
            'sort'             => 'created_at',
            'search'           => ''
        ], $options));

        $searchableFields = ['title', 'slug', 'excerpt', 'content'];

        /*
         * Sorting
         */
        if (in_array($sort, array_keys(static::$allowedSortingOptions))) {
            if ($sort == 'random') {
                $query->inRandomOrder();
            } else {
                @list($sortField, $sortDirection) = explode(' ', $sort);
                if (is_null($sortDirection)) {
                    $sortDirection = "desc";
                }
                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        return $query->paginate($perPage, $page);
    }




    /**
     * Sets the "url" attribute with a URL to this object.
     * @param string $storeName
     * @param Controller $controller
     *
     * @return string
     */
    public function setUrl($storeName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug
        ];

        return $this->url = $controller->pageUrl($storeName, $params);
    }


}
