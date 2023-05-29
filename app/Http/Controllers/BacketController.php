<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backet;

class BacketController extends Controller
{
    private const BACKET_VALIDATOR = [
        "shops_id" => "required",
        "users_id" => "required"
    ];

    private const BACKET_ERROR_MESSAGE = [
        // REQUIRED
        "shops_id.required" => "Укажите ID товара",
        "users_id.required" => "Укажите ID пользователя",  
    ];

    public function create(Request $request)
    {
        $is_valid = $request->validate(
            self::BACKET_VALIDATOR, 
            self::BACKET_ERROR_MESSAGE
        );
        // Логика возврата ответа
        if (array_key_exists('errors', $is_valid))
        {
            return $is_valid;
        } 
        else
        {
            $backet = new Backet();
            $backet->shops_id = $is_valid['shops_id'];
            $backet->users_id = $is_valid['users_id'];
            $backet->save();
            return $backet;
        }
    }

    public function show(Backet $backetUserId)
    {
        return $backetUserId->latest()->get();
    }

    public function delete(Backet $backetId)
    {
        $backetId->delete();
        return $backetId;
    }
}
