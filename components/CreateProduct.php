<?php namespace Shohabbos\Stores\Components;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Offer;

class CreateProduct extends \Cms\Classes\ComponentBase
{
    
    public function componentDetails()
    {
        return [
            'name' => 'Create product',
            'description' => 'Add new product from store'
        ];
    }

    public function onRun() {
        $this->user = Auth::getUser();

        if (!$this->user) {
            return null;
        }
    }


    public function onCreateProduct() {
        $user = Auth::getUser();

        if (!$user) {
            throw new AjaxValidationException('User not fount');
        }

        $data = Input::all(['name', 'category_id', 'store_id', 'preview_image', 'images', 'offers']);

        $rules = [
            'name' => 'required',
        ];

        $validation = Validator::make($data, $rules); 
        if ($validation->fails()) {
            throw new AjaxValidationException($validation);
        }

        $product = new Product($data);
        $product->save();


    }


}