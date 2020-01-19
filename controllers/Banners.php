<?php namespace Shohabbos\Stores\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Banners extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_banners' 
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
