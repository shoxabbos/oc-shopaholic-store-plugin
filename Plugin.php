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
                    $model->store->name = $model->name;
                    $model->store->slug = $model->name;
                    $model->save();
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
            $this->extendProductList($widget);
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
            if (!$model instanceof Product) {
                return;
            }

            if (!$model->exists) {
                return;
            }

            if (!$model->store) {
            	return;
            } else {
            	$fields = Yaml::parseFile('./plugins/shohabbos/stores/models/store/product_store_fields.yaml');
            }
            
            $form->addTabFields($fields);
        });


        $model = Store::find(33);
    }

    public function registerComponents()
    {
        return [
            'Shohabbos\Stores\Components\StorePage' => 'StorePage',
            'Shohabbos\Stores\Components\CreateProduct' => 'CreateProduct'
        ];
    }

    public function registerSettings()
    {
    }








    //
    // Helpers
    //

    private function orderCreatedHandler($order) {
        try {
            Db::transaction(function () use ($order) {
                foreach ($order->order_position as $key => $position) {
                    $store = $position->offer->product->store;
                    $user = $order->user;
                    $amount = $position->total_price_value;

                    $storeOrder = new StoreOrder([
                        'store_id' => $store->id,
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'position_id' => $position->id,
                        'order_id' => $order->id,
                    ]);

                    $storeOrder->save();
                }

            });
        } catch (Exception $e) {
            Log::error(var_export($e, true));
        }
    }    
	
    private function extendUserForm($form, $model, $context) {
        if (!$model instanceof UserModel) {
            return;
        }

        if (!$model->exists) {
            return;
        }

        $form->addTabFields([
            'is_store' => [
                'tab'     => 'rainlab.user::lang.user.account',
                'label'   => 'Is store',
                'type'    => 'switch',
                'span'    => 'auto'
            ]
        ]);

        if (!$model->is_store) {
            return false;
        }

        $fields = Yaml::parseFile('./plugins/shohabbos/stores/models/store/user_fields.yaml');
        $form->addTabFields($fields);


        // add additional fields
        if (!$model->store) {
            $fields = Yaml::parseFile('./plugins/shohabbos/stores/models/store/user_fields.yaml');
        } else {
            $fields = Yaml::parseFile('./plugins/shohabbos/stores/models/store/userstore_fields.yaml');
        }

        $form->addTabFields($fields);
    }

    private function extendUserList($widget) {
        // Only for the User controller
        if (!$widget->getController() instanceof \RainLab\User\Controllers\Users) {
            return;
        }

        // Only for the User model
        if (!$widget->model instanceof \RainLab\User\Models\User) {
            return;
        }

        // Add an extra birthday column
        $widget->addColumns([
            'is_store' => [
                'label' => 'Is store',
                'type' => 'switch'
            ]
        ]);
    }
    private function extendProductList($widget) {
    	// Only for the User controller
        if (!$widget->getController() instanceof \Lovata\Shopaholic\Controllers\Products) {
            return;
        }

        // Only for the User model
        if (!$widget->model instanceof \Lovata\Shopaholic\Models\Product) {
            return;
        }

        // Add an extra birthday column
        
        $widget->addColumns([
		    'store' => [
		        'label' => 'Store',
		        'select' => 'name',
		        'relation' => 'store'
		    ]
		]);
    }

    private function extendUserMenu($manager) {
        $manager->addSideMenuItems('RainLab.User', 'user', [
            'stores' => [
                'label' => 'Stores',
                'url' => Backend::url('shohabbos/stores/stores'),
                'icon' => 'icon-building',
                'permissions' => [
                    'manage_stores'
                ]
            ]
        ]);
    }
    
}
