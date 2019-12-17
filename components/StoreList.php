<?php namespace Shohabbos\Stores\Components;

use Cms\Classes\Page;
use Shohabbos\Stores\Models\Store as StoreModel;

class StoreList extends \Cms\Classes\ComponentBase
{
    public $stores;

    public $storePage;

    public $storesPerPage;

    public function componentDetails()
    {
        return [
            'name' => 'Store list',
            'description' => 'Displays a list of stores'
        ];
    }

    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'Page number',
                'description' => 'Page number',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'storePage' => [
                'title'             => 'Store page',
                'description'       => 'Page slug (Cms page)',
                'type'              => 'dropdown',
                'default'           => 'store/detail',
            ],
            'storesPerPage' => [
                'title'             => 'Stores per page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Error',
                'default'           => '20',
            ],
            'sortOrder' => [
                'title'       => 'Sort by',
                'description' => 'Sort stores',
                'type'        => 'dropdown',
                'default'     => 'published_at desc',
            ],
        ];
    }

    public function onRun() {
        $this->prepareVars();

        $this->stores = $this->page['stores'] = $this->listStores();
    }

    protected function prepareVars() {
        $this->storePage = $this->page['storePage'] = $this->property('storePage');
    }

    public function listStores() {
        $stores = StoreModel::listFrontEnd([
            'page'             => $this->property('pageNumber'),
            'sort'             => $this->property('sortOrder'),
            'perPage'          => $this->property('storesPerPage'),
            'search'           => trim(input('search'))
        ]);

        $stores->each(function($store) {
            $store->setUrl($this->storePage, $this->controller);
        });

        return $stores;
    }

    public function getSortOrderOptions()
    {
        return StoreModel::$allowedSortingOptions;
    }

    public function getStorePageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

}