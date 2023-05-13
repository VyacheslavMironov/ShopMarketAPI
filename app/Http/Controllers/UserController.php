<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    private const USER_REGISTRATION_VALIDATOR = [
        "first_name" => "required|min:2|max:50",
        "last_name" => "required|min:2|max:50",
        "email" => "required|min:8|max:30",
        "phone" => "required|min:16",
        "role" => "required|min:8|max:10",
        "password" => "required|min:10",
    ];

    private const USER_REGISTRATION_ERROR_MESSAGE = [
        // REQUIRED
        "first_name.required" => "Укажите имя",
        "last_name.required" => "Укажите фамилию",
        "email.required" => "Укажите адрес электронной почты",
        "phone.required" => "Введите номер телефона",
        "role.required" => "Укажите роль пользователя",
        "password.required" => "Укажите пароль",
        // MIN
        "first_name.min" => "Имя пользователя не должен быть меньше :min символов",
        "last_name.min" => "Фамилия пользователя не должна быть меньше :min символов",
        "email.min" => "Адрес электронной почты не должен быть меньше :min символов",
        "phone.min" => "Номер телефона не должен быть меньше :min символов",
        "role.min" => "Роль пользователя не должна быть меньше :min символов",
        "password.min" => "Пароль не должен быть меньше :min символов",
        // MAX
        "first_name.max" => "Имя пользователя не должно превышать :max символов",
        "last_name.max" => "Фамилия пользователя не должна превышать :max символов",
        "email.max" => "Адрес электронной почты не должен превышать :max символов",
        "phone.max" => "Номер телефона не должен превышать :max символов",
        "role.max" => "Роль пользователя не должна превышать :max символов",
        "password.max" => "Пароль не должен превышать :max символов",
        
    ];


    public function registration(Request $request)
    {
        $is_valid = $request->validate(
            self::USER_REGISTRATION_VALIDATOR, 
            self::USER_REGISTRATION_ERROR_MESSAGE
        );
        if (array_key_exists('errors', $is_valid))
        {
            return $is_valid;
        } 
        else
        {
            $user = new User();
            $user->first_name = $is_valid["first_name"];
            $user->last_name = $is_valid["last_name"];
            $user->email = $is_valid["email"];
            $user->phone = $is_valid["phone"];
            $user->role = $is_valid["role"];
            $user->password = Hash::make($is_valid["password"]);
            try
            {
                $user->save();
                return $user;
            }
            catch (QueryException)
            {
                return ["errors" => "Пользователь с таким E-mail или номером телефона уже существует!"];
            }
            
        }
    }


    public function auth(User $user, $passwordKey)
    {
        if (Hash::check($passwordKey, $user->password))
        {
            return [$user, "bearerTocken" => User::createBearerTocken($user)];
        }
        return ["errors" => "Данные авторизации введены не правильно!"];
    }
    

    public function logout(User $userId)
    {
        try
        {
            User::deleteBearerTocken($userId);   
        }
        catch(Exception)
        {
            return ["errors" => "Ошибка сервера!"];
        }
    }
}
