<?php namespace Shohabbos\Stores\Components;

use Shohabbos\Stores\Models\Store as StoreModel;

class StorePage extends \Cms\Classes\ComponentBase
{
    
    public $store;

    public function componentDetails()
    {
        return [
            'name' => 'Store page',
            'description' => 'Displays a page of store'
        ];
    }

    public function defineProperties()
    {
        return [
            'page' => [
                'title'             => 'Page url SLUG',
                'description'       => 'Page slug (Url)',
                'default'           => '{{ :slug }}',
                'type'              => 'string',
            ]
        ];
    }


    public function get() {
        if ($this->property('page')) {
        	$this->store = StoreModel::where('slug', $this->property('page'))->first();
    	}	

        return $this->store;
    }

}