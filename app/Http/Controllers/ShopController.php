<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Shop;

class ShopController extends Controller
{
    private const SHOP_VALIDATOR = [
        "title" => "required|min:2|max:190",
        "description" => "required|min:10|max:1500",
        "price" => "required",
        "users_id" => "required"
    ];

    private const SHOP_ERROR_MESSAGE = [
        // REQUIRED
        "title.required" => "Укажите название товара",
        "description.required" => "Заполните описание товара",
        "price.required" => "Укажите цену товара",
        "users_id.required" => "Вы должны быть авторизованным",
        // MIN
        "title.min" => "Название товара не должно быть меньше :min символов",
        "description.min" => "Описание товара не должно быть меньше :min символов",
        // MAX
        "title.max" => "Название товара не должно превышать :max символов",        
        "description.max" => "Описание товара не должно превышать :max символов"     
    ];

    public function all(Request $request)
    {
        return Shop::get();
    }

    public function create(Request $request)
    {
        $is_valid = $request->validate(
            self::SHOP_VALIDATOR, 
            self::SHOP_ERROR_MESSAGE
        );
        // Логика возврата ответа
        if (array_key_exists('errors', $is_valid))
        {
            return $is_valid;
        } 
        else
        {
            $shop = new Shop();
            $shop->title = $is_valid['title'];
            $shop->description = $is_valid['description'];
            $shop->price = $is_valid['price'];
            $shop->slug = Str::slug($is_valid['title'], '_');
            $shop->users_id = $is_valid['users_id'];
            $shop->save();
            return $shop;
        }
    }

    public function update(Request $request)
    {
        $is_valid = $request->validate(
            self::SHOP_VALIDATOR, 
            self::SHOP_ERROR_MESSAGE
        );
        // Логика возврата ответа
        if (array_key_exists('errors', $is_valid))
        {
            return $is_valid;
        } 
        else
        {
            $shop = Shop::find($request->id);
            $shop->title = $is_valid['title'];
            $shop->description = $is_valid['description'];
            $shop->price = $is_valid['price'];
            $shop->slug = Str::slug($is_valid['title'], '_');
            $shop->users_id = $is_valid['users_id'];
            $shop->save();
            return $shop;
        }
    }

    public function show(Shop $shopId)
    {
        try
        {
            return $shopId;
        } 
        catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
        {
            return array("errors" => "Товар не найден!");
        }
        
    }

    public function delete(Shop $shopId)
    {
        try{
            $shopId->delete();
            return $shopId;
        }
        catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
        {
            return array("errors" => "Товар не найден!");
        }
    }
}
