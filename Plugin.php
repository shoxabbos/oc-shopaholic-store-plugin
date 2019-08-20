<?php namespace Shohabbos\Stores;

use Event;
use Backend;
use RainLab\User\Models\User;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{

	public $required = [
		'RainLab.User',
		'Lovata.Shopaholic',
	];

    public function boot()
    {
        // extend user model        
        User::extend(function($model) {
            $model->hasOne['store'] = 'Shohabbos\Stores\Models\Store';
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
        Event::listen('backend.form.extendFields', function($widget) {
            $this->extendUserForm($widget);
        });

        
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }



    //
    // Helpers
    //

    private function extendUserForm($widget) {
        // Only for the User controller
        if (!$widget->getController() instanceof \RainLab\User\Controllers\Users) {
            return;
        }

        // Only for the User model
        if (!$widget->model instanceof \RainLab\User\Models\User) {
            return;
        }

        // Add an extra birthday field
        $widget->addTabFields([
            'is_store' => [
                'tab'     => 'rainlab.user::lang.user.account',
                'label'   => 'Is store',
                'type'    => 'switch',
                'span'    => 'auto'
            ]
        ]);

        $widget->addTabFields([
            'store[name]' => [
                'tab'     => 'Store',
                'label'   => 'Name',
                'span'    => 'auto'
            ]
        ]);

        // Remove a Surname field
        $widget->removeField('surname');
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
