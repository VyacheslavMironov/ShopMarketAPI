<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    private const EVENT_SHOP_VALIDATOR = [
        "title" => "required|min:2|max:10",
        "description" => "required|min:1",
        "price" => "required"
    ];

    private const EVENT_SHOP_ERROR_MESSAGE = [
        // REQUIRED
        "title.required" => "Укажите адрес название",
        "description.required" => "Укажите адрес описание",
        "price.required" => "Укажите адрес цену",
        // MIN
        "title.min" => "Заголовок не должен быть меньше :min символов.",
        "description.min" => "Описание слишком короткое.",
        // REQUIRED
        "title.max" => "Заголовок не должен превышать :max символов.",
    ];

    public function create(Request $request)
    {
        $is_valid = $request->validate(
            self::EVENT_SHOP_VALIDATOR, 
            self::EVENT_SHOP_ERROR_MESSAGE
        );
        
        if (key_exists('errors', $is_valid))
        {
            return $is_valid;
        } else {
            $create = Shop::create([
                "title" => $request->title,
                "description" => $request->description,
                "price" => $request->price
            ]);
            return $create;
        }
    }

    public function show(Shop $item)
    {
        return $item;
    }

    public function all()
    {
        return Shop::get();
    }

    public function update(Request $request)
    {
        $is_valid = $request->validate(
            self::EVENT_SHOP_VALIDATOR, 
            self::EVENT_SHOP_ERROR_MESSAGE
        );
        
        if (key_exists('errors', $is_valid))
        {
            return $is_valid;
        } else {
           $update = Shop::find($request->id);
           $update->title = $is_valid["title"];
           $update->description = $is_valid["description"];
           $update->price = $is_valid["price"];
           $update->save();
           return $update;
        }
    }
}
