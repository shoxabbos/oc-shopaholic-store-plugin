<?php namespace Shohabbos\Stores\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Stores extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'manage_stores' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RainLab.User', 'user', 'stores');
    }
}
