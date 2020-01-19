<?php namespace Shohabbos\Stores;

use Db;
use Log;
use Auth;
use Yaml;
use Event;
use JWTAuth;
use Backend;
use System\Classes\PluginBase;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Controllers\Orders as OrdersController;
use Lovata\Shopaholic\Controllers\Products as ProductsController;

use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;

use Itmaker\Banner\Models\Banner;
use Shohabbos\Stores\Models\Store;
use Shohabbos\Stores\Models\Order as StoreOrder;


class Plugin extends PluginBase
{
	public $required = [
		'RainLab.User',
		'Lovata.Shopaholic',
	];

    public function boot()
    {
    	//expand the plugin. added filable fields
    	Offer::extend(function($model) {
    		$model->addFillable(['property']);
    	});
    	
    	// extend user model        
        UserModel::extend(function($model) {
            $model->bindEvent('model.beforeSave', function() use ($model) {
                if ($model->is_store && !$model->store) {
                    $model->store = new Store();
                }
            });

            $model->hasOne['store'] = 'Shohabbos\Stores\Models\Store';
            $model->addFillable([
            	'phone',
            	'user_address'
            ]);
        });

		Product::extend(function($model) {
            $model->belongsTo['store'] = 'Shohabbos\Stores\Models\Store';
        });
		
		Event::listen('shopaholic.order.created', function($obOrder) {
			$this->orderCreatedHandler($obOrder);
		});

        // extend menu
        Event::listen('backend.menu.extendItems', function($manager) {
            $this->extendUserMenu($manager);
        });
        
        // extend list
        Event::listen('backend.list.extendColumns', function($widget) {
            $this->extendUserList($widget);
        });
        
        // extend form
        UsersController::extendFormFields(function($form, $model, $context) {
            $this->extendUserForm($form, $model, $context);
        });

        // extend product collection
        ProductCollection::extend(function($obProductList) {

            $obProductList->addDynamicMethod('store', function ($id) use ($obProductList) {
                $store = Store::where('id', $id)->first();

                if (!$store || !$store->products) {
                    return $obProductList;
                }

                $data = $store->products()->lists('id');

                return $obProductList->intersect($data);
            });

        });
        
        ProductsController::extendFormFields(function($form, $model, $context) {
            if (!$model instan