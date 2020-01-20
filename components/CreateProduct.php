<?php namespace Shohabbos\Stores\Components;

use Auth;
use Input;
use Flash;
use Redirect;
use Validator;
use Cms\Classes\Page;
use ValidationException;
use Cms\Classes\ComponentBase;
use Rainlab\User\Models\User;
use Lovata\Shopaholic\Models\Product as ProductModel;
use Lovata\PropertiesShopaholic\Models\PropertyValueLink;
use Lovata\Shopaholic\Models\Offer as OfferModel;
use System\Models\File;
use Shohabbos\Stores\Models\Store;
use Itmaker\Banner\Models\Banner;

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
        
        if (!$user || !$user->is_store == true) {
            throw new ValidationException(['massages' => trans("Пользователь не найден")]);
        }
        
        $data = Input::only('name', 'category_id', 'store_id', 'code', 'preview_text', 'description', 'brand_id', 'active', 'preview_image', 'images', 'offers', 'property', 'categoryChildOne_id','categoryChildTwo_id','categoryChildThree_id');
        $additionalCategory = [
        	'one'=>$data['categoryChildOne_id'],
        	'two'=>$data['categoryChildTwo_id'],
        	'three'=>$data['categoryChildThree_id'],
        	'four'=>$data['category_id']
        ]; 
        $rules = [
        	'name' => 'required|min:5',
        	'category_id' => 'required',
        	'preview_text' => 'required|min:5',
        ];
        $validation = Validator::make($data, $rules); 
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        
        $product = new ProductModel($data);
        $product->store_id = $user->store->id;
        $product->preview_image = Input::file('preview_image');
        $product->images = Input::file('images');
        $product->save();
        if (isset($data['property'])) {
        	$product->property = $data['property'];
        	$product->save();	
        }
        $product->additional_category = $additionalCategory;
        $product->save();	
        $product->offer()->createMany($data['offers']);
        $slug = $user->store->slug;
        return Redirect::to('/product-store/' . $slug);
        
    } 
    
    public function onUplodeProduct() {
    	$user = Auth::getUser();
    	$data = Input::only('name', 'category_id', 'store_id', 'code', 'preview_text', 'description', 'brand_id', 'active', 'preview_image', 'images', 'property','categoryChildOne_id','categoryChildTwo_id','categoryChildThree_id');
		$additionalCategory = [
        	'one'=>$data['categoryChildOne_id'],
        	'two'=>$data['categoryChildTwo_id'],
        	'three'=>$data['categoryChildThree_id'],
        	'four'=>$data['category_id']
        ]; 

        $rules = [
            'name' => 'required|min:5',
            'category_id' => 'required',
        ];
        
        $validation = Validator::make($data, $rules); 
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        $product = ProductModel::where('slug', $this->param('slug'))->first();
        
        // update product
        $product->fill($data);
        $product->preview_image = Input::file('preview_image');
        $product->images = Input::file('images');
        $product->update();
        $product->additional_category = $additionalCategory;
        $product->update();
        if (isset($data['property'])) {
        	$product->property = $data['property'];
        	$product->update();	
        }        
        $slug = $user->store->slug;
        return Redirect::to('/product-store/' . $slug);
    }
    
    public function onOfferUpdate() {
    	$data = Input::only('name', 'active', 'price', 'old_price', 'quantity', 'offer_id'); 
    	$rules = [
	        'price' => 'integer',
	        'old_price' => 'integer',
	        'quantity' => 'integer',
	    ];
	
	    $validation = Validator::make($data, $rules);
	    if ($validation->fails()) {
	        throw new ValidationException($validation);
	    }
    	$obOffer = OfferModel::where('id', $data['offer_id'])->first();
    	$obOffer->name = $data['name'];
    	$obOffer->active = $data['active'];
    	$obOffer->price = $data['price'];
    	$obOffer->old_price = $data['old_price'];
    	$obOffer->quantity = $data['quantity'];
    	$obOffer->update();
    }
    
    public function onOfferCreate() {
    	$user = Auth::getUser();
    	$data = Input::only('offers');
    	$product = ProductModel::where('slug', $this->param('slug'))->first();
		$product->offer()->createMany($data['offers']);
    	
    	$product = ProductModel::where('slug', $this->param('slug'))->first();
		return Redirect::to('update-product/'.$product->slug);
    }
    
    public function onOfferRemove() {
    	$offerId = Input::only('data');
    	OfferModel::where('id', $offerId)->delete();	
    	
    	$product = ProductModel::where('slug', $this->param('slug'))->first();
		return Redirect::to('update-product/'.$product->slug);
    }
    
	public function onStoreUpdate() {
		$user = Auth::getUser();
		$data = Input::only('name', 'legal_name', 'address', 'contacts', 'email', 'header_image', 'logo', 'aggree');
		
		$messages = [
            'required.name' => "To'ldirish shart",
        ];

		$relus = [
			'name' => 'string',
			'legal_name' => 'string'
		];
		
		$validation = Validator::make($data, $relus);
		if($validation->fails()){
			throw new ValidatorException($validation); 
		}
		
		$store = Store::where('id', $user->store->id)->first();
		$store->legal_name = $data['legal_name'];
		$store->name = $data['name'];
		$store->address = $data['address'];
		$store->contacts = $data['contacts'];
		$store->email = $data['email'];
		if (empty($store->slug)){
			$store->slug = $user->name;	
		}
		$store->header_image = Input::file('header_image');		
		$store->logo = Input::file('logo');		
		$store->save();
		return;
	}
	
	function onRemove() {
		$user = Auth::getUser();
		$productId = Input::only('data');
		ProductModel::where('id', $productId)->delete();
		
		$storeUrl = Store::where('slug', $user->store->slug)->first();
		return Redirect::to('product-store/'.$storeUrl->slug);
	}
}
