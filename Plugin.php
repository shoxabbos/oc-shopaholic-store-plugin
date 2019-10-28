<?php namespace Shohabbos\Stores;

use Yaml;
use Event;
use Backend;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
use Lovata\Shopaholic\Controllers\Products as ProductsController;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Shohabbos\Stores\Models\Store;
use Itmaker\Banner\Models\Banner;
use System\Classes\PluginBase;

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
    	/*Product::extend(function($model){
    		$model->addFillable(['additional_category']);	
    	});*/
    	
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
        
        UsersController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof UserModel) {
                return;
            }

            if (!$model->exists) {
                return;
            }
            if (!$model->store) {
            	$fields = Yaml::parseFile('./plugins/shohabbos/stores/models/store/user_fields.yaml');
            } else {
            	$fields = Yaml::parseFile('./plugins/shohabbos/stores/models/store/userstore_fields.yaml');
            }
            $form->addTabFields($fields);	
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

    private function extendUserForm($form, $model, $context) {
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
